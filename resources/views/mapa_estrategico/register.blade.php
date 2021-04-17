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
                <span class="font-weight-bold ml-3" >REGISTRAR MAPA ESTRATEGICO</span>
            </div>
        </div>
            <div class="row">

                <div class="col-12 mt-5">
                    {!! Form::open(['action' => ['MapaEstrategicoController@store','empresa'=>Request()->empresa,'proceso'=>Request()->proceso],'method'=>'POST']) !!}
                    <div class="form-group">
                        {{Form::label('nombre','Nombre')}}
                        {{Form::text('nombre','',['class'=> eClass( $errors->getBag('default')->first('nombre')),'placeholder'=>'Nombre'])}}
                        <div class="invalid-feedback">
                            @error('nombre') {{$message}} @enderror
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
@endsection
