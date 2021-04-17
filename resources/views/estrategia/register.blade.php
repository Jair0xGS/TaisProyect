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
                        ['EstrategiaController@store',
                        'empresa'=>Request()->empresa,
                        'proceso'=>Request()->proceso,
                        'mapa_estrategico'=>Request()->mapa_estrategico,
                        ],
                        'method'=>'POST']) !!}
                    <div class="form-group">
                        {{Form::label('nombre','Nombre')}}
                        {{Form::text('nombre','',['class'=> eClass( $errors->getBag('default')->first('nombre')),'placeholder'=>'Nombre'])}}
                        <div class="invalid-feedback">
                            @error('nombre') {{$message}} @enderror
                        </div>

                    </div>

                    <div class="form-group">
                        {{Form::label('estrategia_id','Estrategia a Referenciar')}}
                        {{Form::select('estrategia_id',[],null,['class'=> eClass( $errors->getBag('default')->first('estrategia_id')),'placeholder'=>'Estrategia a Referenciar'])}}
                        <div class="invalid-feedback">
                            @error('estrategia_id') {{$message}} @enderror
                        </div>
                    </div>


                </div>
                <div class="col-6 mt-5">

                    <div class="form-group">
                        {{Form::label('perspectiva_id','Perspectiva')}}
                        {{Form::select('perspectiva_id',$perspectivas->pluck('nombre','id'),null,['class'=> eClass( $errors->getBag('default')->first('perspectiva_id')),'placeholder'=>'Perspectiva'])}}
                        <div class="invalid-feedback">
                            @error('perspectiva_id') {{$message}} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('relacion_id','Relacion')}}
                        {{Form::select('relacion_id',$relaciones->pluck('nombre','id'),null,['class'=> eClass( $errors->getBag('default')->first('relacion_id')),'placeholder'=>'Relacion'])}}
                        <div class="inv alid-feedback">
                            @error('relacion_id') {{$message}} @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group pagination mt-5">
                        {{Form::submit('Guardar Proceso',['class'=>'btn btn-lg btn-primary'])}}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>


        </div>


    </div>
@endsection


@section('js')
<script>
    let allEstrategias = {{ $relaciones->pluck('nombre','perspectiva_id','id') }};

    console.log(allEstrategias);


</script>
@endsection
