
@role('supervisor')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fab fa-gitter"></i>
            <span class="font-weight-bold ml-3" >INDICADORES</span>
        </div><br>
    </div>
    <div style="margin-left: 150px;margin-right: 150px">

        <br><br>
        @if(session('datos'))
            <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('datos')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(count($indicador)>0)
            <table class="table table-hover text-center">
                <thead>
                <tr>
                    <th scope="col">Denominación</th>
                    <th scope="col">Objetivo</th>
                    <th scope="col">Fórmula</th>
                    <th scope="col">Tolerancia</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Acción</th>
                </tr>
                </thead>
                <tbody>

                @foreach($indicador as $itemIndicador)
                    <tr>
                        <td>{{$itemIndicador->descripcion}}</td>
                        <td>{{$itemIndicador->objetivo}}</td>
                        <td>{{$itemIndicador->formula}}</td>
                        <td>{{$itemIndicador->tolerancia}}</td>
                        <td>{{$itemIndicador->unidad}}</td>
                        <td>
                            <div class="color-titulo row" style="font-size: 25px">
                                <a href="" class="col-12 p-0"><i class="fas fa-eye btn-eliminar"></i></a>
                            </div>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table><br>
            <div class="row justify-content-center">
                {{$indicador->links()}}
            </div>
        @else
            <div class="row">
                <div class="col-12 mb-5 alert alert-info alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                    Sin indicadores disponibles para mostrar...
                </div>
            </div>
        @endif
    </div>

@endsection
@endrole
