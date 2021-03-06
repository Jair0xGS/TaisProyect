
@extends('layouts.plantilla')

@section('contenido')
    @php

        function eClass ($name) {
            if ($name != null){
                return 'form-control  is-invalid';
            }
            return 'form-control ';
         };

        function eInvalid ($name) {
            if ($name != null){
                return 'is-invalid';
            }
            return '';
         };
    @endphp
    <div class="container">
        <div class="row ">
            <a href="{{route('tablero.index',Request()->indicador)}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >REGISTRAR TABLERO</span>
            </div>
        </div>
        <div class="row">



            <div class="col-6 ">
                {!! Form::open(['action' => ['TableroController@update',Request()->indicador,$data->id],'method'=>'PUT']) !!}
                <div class="form-group">
                    {{Form::label('frecuencia','Frecuencia')}}
                    {{Form::select('frecuencia',[
                        "Mensual"=>"Mensual",
                        "Anual"=>"Anual"
                        ],$data->frecuencia,['class'=> eClass( $errors->getBag('default')->first('frecuencia')),'placeholder'=>'Frecuencia'])}}
                    <div class="invalid-feedback">
                        @error('frecuencia') {{$message}} @enderror
                    </div>
                </div>

            </div>
            <div class="col-6 ">
                <div class="form-group">
                    {{Form::label('iniciativas','Iniciativas')}}
                    {{Form::textarea('iniciativas',$data->iniciativas,['class'=> eClass( $errors->getBag('default')->first('iniciativas')),'placeholder'=>'Iniciativas',"rows"=>"2"])}}
                    <div class="invalid-feedback">
                        @error('iniciativas') {{$message}} @enderror
                    </div>
                </div>

            </div>
            <div class="col-12">
                <label  for="verde">Estamos Bien</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-success"> </div>
                    </div>
                    <input
                        type="number"
                        class="form-control {{eInvalid( $errors->getBag('default')->first('verde'))}}"
                        id="verde"
                        name="verde"
                        value="{{$data->verde}}"
                        onchange="changeVerde(this)"
                        placeholder="Estamos Bien"
                        @if($incidencia->formula_id!=3)
                        step =0.01
                        max="100"
                        min="0"
                        @endif
                        @if($incidencia->formula_id==3)
                        min="0"
                        @endif
                    >
                    {{Form::select('verde_operador',[
                        ">"=>">",
                        ">="=>">=",
                        "<"=>"<",
                        "<="=>"<=",
                        ],$data->verde_operador,
                        [
                        'class'=> eClass( $errors->getBag('default')->first('frecuencia')),
                        'placeholder'=>'Operador',
                        'onclick'=>'trigger(this)',"id"=>"verdeOperador"
                        ]
                        )}}
                    <div class="invalid-feedback">
                        @error('verde') {{$message}} @enderror
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group pagination mt-5">
                    {{Form::submit('Guardar Tablero',['class'=>'btn btn-lg btn-primary'])}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>




    </div>
@endsection
