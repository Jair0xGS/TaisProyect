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
            <a href="{{route('proceso.index',[Request()->empresa])}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >REGISTRAR PROCESO</span>
            </div>
        </div>
        <div class="row">

            <div class="col mb-3">
                <h1>Registrar Proceso</h1>

            </div>
        </div>
            <div class="row">

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
                    <div class="form-group">
                        {{Form::label('personal_id','Personal Encargado')}}
                        {{Form::select('personal_id',$personals->pluck('full_name','id'),null,['class'=> eClass( $errors->getBag('default')->first('personal_id')),'placeholder'=>'Personal'])}}
                        <div class="invalid-feedback">
                            @error('personal_id') {{$message}} @enderror
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
@endif
@endrole
