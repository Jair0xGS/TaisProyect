
@role('supervisor')
@extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="row ">
            <a href="{{route('tablero.index',$tablero->indicador_id)}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo m-5" style="font-size: 30px">
                <i class="fab fa-gitter"></i>
                <span class="font-weight-bold ml-3" >TABLERO DE COMANDO</span>
            </div><br>
        </div>
        <div class="row">

            <br><br>
            @if(session('datos'))
                <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                    <strong>ATENCIÓN</strong> {{session('datos')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-2" >
                    <div class=" color-degradado  text-white text-center card" style="border-radius: 120px">
                        <div class="card-body">
                            <span style="color: #aea1fc"><b>OJETIVO</b></span><br>
                            {{$tablero->indicador->objetivo}}
                        </div>
                    </div>

                </div>
                <div class="col-2">
                    <div class="  text-center  card">
                        <div class="card-body">
                            <span class="text-main"><b>INDICADOR</b></span><br>
                            {{$tablero->indicador->descripcion}}
                        </div>
                    </div>
                </div>
                <div class="col-3" >
                    <div  class="color-degradado  text-white text-center card" style="border-radius: 120px">
                        <div class="card-body">
                            <span style="color: #aea1fc"><b>META</b></span><br>
                            @if($tablero->verde_operador == '>')
                                Mas de
                            @endif
                            @if($tablero->verde_operador == '<')
                                Menos de
                            @endif
                            @if($tablero->verde_operador == '>=')
                                Mas o igual que
                            @endif
                            @if($tablero->verde_operador == '<=')
                                Menos o igual que
                            @endif
                            {{$tablero->amarillo}}
                            @if($tablero->indicador->formula_id != 3)
                                %
                            @endif

                        </div>
                    </div>

                </div>
                <div class="col-4 ">
                    <div class="text-center card">


                        <div class="card-body">
                            <span class="text-main"><b>SEMÁFORO</b></span><br>
                            <div class="row">
                                <div class="col-3 p-2 bg-danger">

                                </div>
                                <div class="col-9">
                                    @if($tablero->verde_operador == '>')
                                        Menos o igual que
                                    @endif
                                    @if($tablero->verde_operador == '<')
                                        Mas o igual que
                                    @endif
                                    @if($tablero->verde_operador == '>=')
                                        Menos de
                                    @endif
                                    @if($tablero->verde_operador == '<=')
                                        Mas de
                                    @endif
                                    {{$tablero->amarillo}}
                                        @if($tablero->indicador->formula_id != 3)
                                            %
                                        @endif

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3 p-2 bg-warning">

                                </div>
                                <div class="col-9">
                                    Entre
                                    {{$tablero->amarillo}}
                                    @if($tablero->indicador->formula_id != 3)
                                        %
                                    @endif
y
                                    {{$tablero->verde}}
                                    @if($tablero->indicador->formula_id != 3)
                                        %
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3 p-2 bg-success">

                                </div>
                                <div class="col-9">
                                    @if($tablero->verde_operador == '>')
                                        Mas de
                                    @endif
                                    @if($tablero->verde_operador == '<')
                                        Menos de
                                    @endif
                                    @if($tablero->verde_operador == '>=')
                                        Mas o igual que
                                    @endif
                                    @if($tablero->verde_operador == '<=')
                                        Menos o igual que
                                    @endif
                                    {{$tablero->verde}}
                                    @if($tablero->indicador->formula_id != 3)
                                        %
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 "></div>
                <div class="col-6  ">
                    <div class="text-center  card">


                        <div class="card-body">
                            <span class="text-main"><b>INICIATIVAS</b></span><br>
                            {{$tablero->iniciativas}}
                        </div>
                    </div>
                </div>
                <div class="col-3  ">
                    <div class="text-center  card">
                        <div class="card-body">
                            <span class="text-main"><b>RESPONSABLE</b></span><br>
                            {{$tablero->indicador->personal->nombres}} {{$tablero->indicador->personal->apellidos}}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
@endrole
