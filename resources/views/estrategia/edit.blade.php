@role('admin')
@if(Auth::user()->Empresa->id == Request()->empresa)

    @extends('layouts.plantilla')

@section('contenido')
    @php

        function eClass ($name) {
            if ($name != null){
                return 'form-control  is-invalid';
            }
            return 'form-control ';
         };

    @endphp
    <div class="container">
        <div class="row ">
            <a href="{{route('mapa_estrategico.show',[Request()->empresa,Request()->proceso,Request()->mapa_estrategico])}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >EDITAR ESTRATEGIA</span>
            </div>
        </div>
        <div class="row">

            <div class="col-6 mt-5">
                {!! Form::open(['action' =>
                    ['EstrategiaController@update',
                    'empresa'=>Request()->empresa,
                    'proceso'=>Request()->proceso,
                    'mapa_estrategico'=>Request()->mapa_estrategico,
                    'estrategium'=>Request()->estrategium,
                    ],
                    'method'=>'PUT']) !!}
                <div class="form-group">
                    {{Form::label('nombre','Nombre')}}
                    {{Form::text(
                        'nombre',
                        $data->nombre,
                            [
                                'class'=> eClass( $errors->getBag('default')->first('nombre')),
                                'placeholder'=>'Nombre'
                                ]
                        )
                    }}
                    <div class="invalid-feedback">
                        @error('nombre') {{$message}} @enderror
                    </div>

                </div>

                <div class="form-group">
                    {{Form::label('estrategia_id','Estrategia a Referenciar')}}
                    {{Form::select('estrategia_id[]',
                        [],
                        $data->estrategia_id,
                        [
                            'class'=> eClass( $errors->getBag('default')->first('estrategia_id')),
                            'placeholder'=>'Estrategia a Referenciar',
                            'id'=>'estrategia_id',
                            'multiple'
                            ]
                        )
                    }}
                    <div class="invalid-feedback">
                        @error('estrategia_id') {{$message}} @enderror
                    </div>
                </div>


            </div>

            <div class="col-6 mt-5">

                <div class="form-group">
                    {{Form::label('perspectiva_id','Perspectiva')}}
                    {{Form::select('perspectiva_id',
                        $perspectivas->pluck('nombre','id'),
                        $data->perspectiva_id,
                            [
                                'class'=> eClass( $errors->getBag('default')->first('perspectiva_id')),
                                'placeholder'=>'Perspectiva',
                                'onchange'=>'trigger(this)',
                            ]
                        )
                    }}
                    <div class="invalid-feedback">
                        @error('perspectiva_id') {{$message}} @enderror
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('relacion_id','Relacion')}}
                    {{Form::select('relacion_id',
                        $relaciones->pluck('nombre','id'),
                        $data->relacion_id,
                        [
                            'class'=> eClass( $errors->getBag('default')->first('relacion_id')),
                            'placeholder'=>'Relacion'
                        ]
                    )
                    }}
                    <div class="invalid-feedback">
                        @error('relacion_id') {{$message}} @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group pagination mt-5">
                    {{Form::submit('Guardar Estrategia',['class'=>'btn btn-lg btn-primary'])}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>


    </div>
@endsection


@section('js')
    <script>
        function trigger(selected) {
            let current_id = {{ $data->id }};
            //console.log("{{ $estrategias->toJson()}}".replaceAll("&quot;",'"'))
            console.log("---------------------------------------------------")
            console.log(selected.value)
            var allEstrategias = JSON.parse("{{ $estrategias->toJson()}}".replaceAll("&quot;",'"'));

            //check if es una perspectiva financiera
            var selEstrategia = document.getElementById("estrategia_id");
            selEstrategia.disabled=false;

            if (selected.value == 1){
                selEstrategia.disabled=true;
                return;
            }

            console.log("lenght options select "+selEstrategia.options.length)
            selEstrategia.innerHTML=null;
            selEstrategia.add(new Option( "Estrategia a Refereneciar" ));


            for (var ix in allEstrategias) {
                if (parseInt(allEstrategias[ix].perspectiva_id) <= parseInt(selected.value)){
                    if(allEstrategias[ix].id != current_id){

                    console.log(allEstrategias[ix]);
                    selEstrategia.add(new Option( allEstrategias[ix].nombre, allEstrategias[ix].id ));
                    }

                }
            }
            return;

        }
        function initEstrategias(){
            let selected_ids = JSON.parse("{{ $data->estrategias->toJson() }}".replaceAll("&quot;",'"'));
            let current_id = {{ $data->id }};

            console.log("{{ $estrategias->toJson() }}".replaceAll("&quot;",'"'))
            console.log("exec init");
            console.log(selected_ids);
            let allEstrategias = JSON.parse("{{ $estrategias->toJson() }}".replaceAll("&quot;",'"'));
            console.log(allEstrategias);
            console.log(allEstrategias.length);
            var sel = document.getElementById("estrategia_id");
            var selected = document.getElementById("perspectiva_id");
            if( allEstrategias.length == 0){
                sel.disabled=true;
                return;
            }
            for (var ix in allEstrategias) {
                if (parseInt(allEstrategias[ix].perspectiva_id) <= parseInt(selected.value)){
                    if(allEstrategias[ix].id != current_id){
                        console.log(allEstrategias);
                sel.add(new Option( allEstrategias[ix].nombre, allEstrategias[ix].id ));

                    }

                }

            }

            //trigger(sel);
            for (var i = 0; i < sel.options.length; i++) {
                for (let j = 0; j < selected_ids.length; j++) {
                    if (sel.options[i].value ==  selected_ids[j].estrategia_to_id){

                        sel.options[i].selected =true;
                    }
                }

            }
            return;
        }
        window.onload = function() {
            initEstrategias()
        };

    </script>
@endsection
@endif
@endrole
