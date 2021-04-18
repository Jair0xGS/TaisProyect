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
        <div class="row justify-content-center ">
            <div class="color-titulo m-5" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >REGISTRAR ESTRATEGIA</span>
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
                    {{Form::select('estrategia_id',
                        [],
                        $data->estrategia_id,
                        [
                            'class'=> eClass( $errors->getBag('default')->first('estrategia_id')),
                            'placeholder'=>'Estrategia a Referenciar'
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
                if (parseInt(allEstrategias[ix].perspectiva_id) < parseInt(selected.value)){
                    console.log(allEstrategias[ix]);
                    selEstrategia.add(new Option( allEstrategias[ix].nombre, allEstrategias[ix].id ));

                }
            }
            return;

        }
        function initEstrategias(){
            let selected_id = {{ $data->estrategia_id }};

            console.log("{{ $estrategias->toJson() }}".replaceAll("&quot;",'"'))
            console.log("exec init");
            console.log(selected_id);
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
                if (parseInt(allEstrategias[ix].perspectiva_id) < parseInt(selected.value)){
                console.log(allEstrategias);
                sel.add(new Option( allEstrategias[ix].nombre, allEstrategias[ix].id ));
                }

            }

            //trigger(sel);
            sel.value = selected_id;
            return;
        }
        window.onload = function() {
            initEstrategias()
        };

    </script>
@endsection
