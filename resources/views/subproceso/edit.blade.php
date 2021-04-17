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
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="color-titulo m-5" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >EDITAR SUBPROCESO</span>
            </div>
        </div>

        <div class="row">


            <div class="col-6 mt-5">
                {!! Form::open(['action' => ['SubProcesoController@update','empresa'=>Request()->empresa,'proceso'=>Request()->proceso,'subproceso'=>Request()->subproceso],'method'=>'PUT']) !!}
                <div class="form-group">
                    {{Form::label('nombre','Nombre')}}
                    {{Form::hidden('empresa_id',Request()->empresa)}}
                    {{Form::hidden('proceso_id',Request()->proceso)}}
                    {{Form::text('nombre',$data->nombre,['class'=> eClass( $errors->getBag('default')->first('nombre')),'placeholder'=>'Nombre'])}}
                    <div class="invalid-feedback">
                        @error('nombre') {{$message}} @enderror
                    </div>

                </div>


            </div>
            <div class="col-6 mt-5">

                <div class="form-group">
                    {{Form::label('personal_id','Personal Encargado')}}
                    {{Form::select('personal_id',$personals->pluck('nombres','id'),$data->personal_id,['class'=> eClass( $errors->getBag('default')->first('personal_id')),'placeholder'=>'Personal'])}}
                    <div class="invalid-feedback">
                        @error('personal_id') {{$message}} @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group pagination mt-5">
                    {{Form::submit('Guardar SubProceso',['class'=>'btn btn-lg btn-primary'])}}
                </div>
                {!! Form::close() !!}
            </div>


        </div>


    </div>
@endsection
