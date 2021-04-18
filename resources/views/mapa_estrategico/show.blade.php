@extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="color-titulo m-5" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" > {{$data->nombre}} </span>
            </div>
        </div>
        <div class="row ">
            <div class="container">
                <div class="row">
                    <div class="col-10">

                    </div>
                    <div class="col-2 mb-3">
                        <a href="{{route('estrategia.create',[Request()->empresa,Request()->proceso,Request()->mapa_estrategico])}}" class="btn btn-primary" role="button" aria-pressed="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Estrategia
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <table class="table mb-5">

                            <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Perspectiva</th>
                                <th scope="col">Relacion</th>
                                <th scope="col">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->estrategias as $elem)

                                <tr>
                                    <td>
                                        {{$elem->nombre}}
                                    </td>
                                    <td>
                                        {{$elem->perspectiva->nombre}}
                                    </td>
                                    <td>
                                        {{$elem->relacion->nombre}}
                                    </td>
                                    <td>
                                        <div class="color-titulo row" style="font-size: 25px">

                                            <a href="{{route('estrategia.edit',[
                                                            Request()->empresa,
                                                            Request()->proceso,
                                                            Request()->mapa_estrategico,
                                                            $elem->id
                                                            ])}}" class="col-4 p-0" aria-pressed="true"><i class="fas fa-pen-square btn-editar"></i>
                                            </a>
                                            <a  class="col-4 p-0" aria-pressed="true"><i class="fas fa-trash-alt btn-eliminar" aria-pressed="true" data-toggle="modal" data-target="#exampleModal{{$elem->id}}"></i>
                                            </a>

                                            <div class="modal fade" id="exampleModal{{$elem->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Borrado</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Seguro que desea borrar esta estrategia ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            {!! Form::open(['action' => ['EstrategiaController@destroy',Request()->empresa,Request()->proceso,Request()->mapa_estrategico,$elem->id],'method'=>'POST']) !!}
                                                            {{Form::hidden('_method','DELETE')}}
                                                            {{Form::submit('Borrar',['class'=>'btn btn-dark'])}}
                                                            {!! Form::close() !!}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
