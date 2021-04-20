
@role('supervisor')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fab fa-gitter"></i>
            <span class="font-weight-bold ml-3" >TABLERO DE COMANDO</span>
        </div><br>
    </div>
    <div class="m-5">

        <br><br>
        @if(session('datos'))
            <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('datos')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row m-5">
            <div class="col-2 color-degradado m-3 text-white text-center p-3 card" style="border-radius: 120px">
                    <div class="card-body">
                        <span style="color: #aea1fc"><b>OJETIVO</b></span><br>
                        {{$tablero->indicador->objetivo}}
                    </div>
            </div>
            <div class="col-3 m-3 text-center p-3 card">
                <div class="card-body">
                    <span class="text-main"><b>INDICADOR</b></span><br>
                    {{$tablero->indicador->descripcion}}
                </div>
            </div>
            <div class="col-2 color-degradado m-5 text-white text-center p-3 card" style="border-radius: 120px">
                <div class="card-body">
                    <span style="color: #aea1fc"><b>META</b></span><br>
                    Valor signoooooooooooo*******
                    {{$tablero->rojo}}
                </div>
            </div>
            <div class="col-3 m-3 text-center p-3 card">
                <div class="card-body">
                    <span class="text-main"><b>SEMÁFORO</b></span><br>
                    <div class="row">
                        <div class="col-3 p-2 bg-danger">

                        </div>
                        <div class="col-9">
                            ESTAMOS MAL
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3 p-2 bg-warning">

                        </div>
                        <div class="col-9">
                            ESTAMOS EN EL LÍMITE
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3 p-2 bg-success">

                        </div>
                        <div class="col-9">
                            ESTAMOS BIEN
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2 m-3"></div>
            <div class="col-6 m-3 text-center p-3 card">
                <div class="card-body">
                    <span class="text-main"><b>INICIATIVAS</b></span><br>
                    {{$tablero->iniciativas}}
                </div>
            </div>
            <div class="col-3 m-3 text-center p-2 card">
                <div class="card-body">
                    <span class="text-main"><b>RESPONSABLE</b></span><br>
                    {{$tablero->indicador->personal->nombres}} {{$tablero->indicador->personal->apellidos}}
                </div>
            </div>

        </div>

    </div>

@endsection
@endrole
