@extends('layouts.app')

@section('content')
    @php

        function eClass ($name) {
            if ($name != null){
                return 'form-control  is-invalid';
            }
            return 'form-control ';
         };

    @endphp
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Creacion Proceso</h1>

            </div>


            <div class="col-6 mt-5">
                {!! Form::open(['action' => ['ProcesoController@store','empresa'=>Request()->empresa],'method'=>'POST']) !!}
                <div class="form-group">
                    {{Form::label('nombre','Nombre')}}
                    {{Form::hidden('empresa_id',Request()->empresa)}}
                    {{Form::text('nombre','',['class'=> eClass( $errors->getBag('default')->first('nombre')),'placeholder'=>'Nombre'])}}
                    <div class="invalid-feedback">
                        @error('nombre') {{$message}} @enderror
                    </div>

                </div>


            </div>
            <div class="col-6 mt-5">

                <div class="form-group">
                    {{Form::label('tipo_proceso_id','Tipo Proceso')}}
                    {{Form::select('tipo_proceso_id',$tipo_procesos->pluck('tipo','id'),null,['class'=> eClass( $errors->getBag('default')->first('tipo_proceso_id')),'placeholder'=>'Tipo Proceso'])}}
                    <div class="invalid-feedback">
                        @error('tipo_proceso_id') {{$message}} @enderror
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
