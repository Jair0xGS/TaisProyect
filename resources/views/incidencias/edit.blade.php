@role('user')
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
            <a href="{{route('incidencia.index')}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >REGISTRAR INCIDENCIA</span>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-5">
                {!! Form::open(['action' => ['IncidenciaController@update',$data->id],'method'=>'PUT']) !!}
                <div class="form-group">
                    {{Form::label('descripcion','Descripcion')}}
                    {{Form::text('descripcion',$data->descripcion,['disabled','class'=> eClass( $errors->getBag('default')->first('descripcion')),'placeholder'=>'Descripcion'])}}
                    <div class="invalid-feedback">
                        @error('descripcion') {{$message}} @enderror
                    </div>

                </div>


            </div>
            <div class="col-4 mt-5">
                <div class="form-group">
                    {{Form::label('solucion','Solucion')}}
                    {{Form::text('solucion',$data->solucion,['class'=> eClass( $errors->getBag('default')->first('solucion')),'placeholder'=>'Solucion'])}}
                    <div class="invalid-feedback">
                        @error('solucion') {{$message}} @enderror
                    </div>

                </div>


            </div>
            <div class="col-4 mt-5">
                <div class="form-group">
                    {{Form::label('estado','Estado')}}
                    {{Form::select('estado',["Solucionado"=>"Solucionado","Sin Solucionar"=>"Sin Solucionar" ],$data->estado,['onclick'=>'trigger(this)','class'=> eClass( $errors->getBag('default')->first('estado')),'placeholder'=>'Estado'])}}
                    <div class="invalid-feedback">
                        @error('estado') {{$message}} @enderror
                    </div>
                </div>

            </div>
            <div class="col-12">
                <div class="form-group pagination mt-5">
                    {{Form::submit('Guardar Mapa Estrategico',['class'=>'btn btn-lg btn-primary'])}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>




    </div>
@endsection
@section('js')
    <script>
        var sel = document.getElementById("estado");
        function trigger(sel) {
        var selSolucion = document.getElementById("solucion");
            if (sel.value == "Sin Solucionar"){
                selSolucion.disabled =true;
                return
            }
            selSolucion.disabled =false;
            return
        }
        trigger(sel);
    </script>
    @endsection
@endrole
