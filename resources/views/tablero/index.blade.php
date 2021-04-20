
    @extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="row ">
            <a href="{{route('indicadores.index')}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" > MONITOREO DE INDICADOR</span>
            </div>
        </div>
        <div class="row ">
            <div class="container">

                <div class="row mt-4">
                    <div class="col-10">

                    </div>
                    <div class="col-2 mb-3">
                        <a href="{{route('tablero.create',Request()->indicador)}}" class="btn btn-primary" role="button" aria-pressed="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Tablero
                        </a>
                    </div>
                </div>
                <div class="row mb-5">
                    @foreach($data as $elem)
                        <div class="col-12 my-4">
                            <div class="container">
                                <div class="row ">
                                    <div class="col-9">

                                    <h3>{{$elem->descripcion}}</h3>
                                    </div>

                                    <div class="col-1">

                                        <a href="{{route('indicadores.show',[$elem->id])}}" class=" p-0 btn-lg btn-block" aria-pressed="true"><i class="fas fa-eye text-success"></i>
                                        </a>

                                    </div>
                                    <div class="col-1">
                                        <a href="{{route('tablero.edit',[Request()->indicador,$elem->id])}}" class=" p-0 btn-lg btn-block" aria-pressed="true"><i class="fas fa-pen-square btn-editar"></i>
                                        </a>

                                    </div>
                                    <div class="col-1">
                                        <a  class="p-0 btn-lg btn-block" aria-pressed="true"><i class="fas fa-trash-alt btn-eliminar" aria-pressed="true" data-toggle="modal" data-target="#exampleModal{{$elem->id}}"></i>
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
                                                        Seguro que desea borrar este tablero ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        {!! Form::open(['action' => ['TableroController@destroy',Request()->indicador,$elem->id],'method'=>'POST']) !!}
                                                        {{Form::hidden('_method','DELETE')}}
                                                        {{Form::submit('Borrar',['class'=>'btn btn-dark'])}}
                                                        {!! Form::close() !!}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                    <table class="table table-bordered " style="text-align: center">
                                        <thead>
                                        <tr  >
                                            <th colspan="{{5+ $elem->semaforo->count()}}" scope="col">{{$indicador->descripcion}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" rowspan="2">Formula</th>
                                            <th scope="row" rowspan="2">Frecuencia de Medicion</th>
                                            <th scope="row"  colspan="3">SEMAFORO</th>
                                            @if($elem->semaforo->count() != 0)
                                            <th scope="row" colspan="{{$elem->semaforo->count()}}">
                                                {{$elem->frecuencia}}
                                            </th>
                                                @endif

                                        </tr>
                                        <tr>
                                            <td class="bg-success"></td>
                                            <td class="bg-warning"></td>
                                            <td class="bg-danger"></td>
                                            @foreach($elem->semaforo as $sem)

                                            <td
                                                class="{{$sem["color"]}}">{{$sem["fecha"]}}</td>

                                                @endforeach

                                        </tr>
                                        <tr>
                                            <td >{{$indicador->formula}}</td>
                                            <td>{{$elem->frecuencia}}</td>
                                            <td >
                                                @if($elem->verde_operador == '>')
                                                    Mas de
                                                @endif
                                                @if($elem->verde_operador == '<')
                                                    Menos de
                                                @endif
                                                @if($elem->verde_operador == '>=')
                                                    Mas o igual que
                                                @endif
                                                @if($elem->verde_operador == '<=')
                                                    Menos o igual que
                                                @endif
                                                {{$elem->verde}}
                                            </td>
                                            <td >
                                                @if($elem->verde_operador == '>')
                                                    Menos o igual que
                                                @endif
                                                @if($elem->verde_operador == '<')
                                                    Mas o igual que
                                                @endif
                                                @if($elem->verde_operador == '>=')
                                                    Menos de
                                                @endif
                                                @if($elem->verde_operador == '<=')
                                                    Mas de
                                                @endif
                                                {{$elem->verde}},
                                                    @if($elem->verde_operador == '>')
                                                        Mas de
                                                    @endif
                                                    @if($elem->verde_operador == '<')
                                                        Menos de
                                                    @endif
                                                    @if($elem->verde_operador == '>=')
                                                        Mas o igual que
                                                    @endif
                                                    @if($elem->verde_operador == '<=')
                                                        Menos o igual que
                                                    @endif
                                                    {{$elem->amarillo}}</td>
                                            <td >
                                                @if($elem->verde_operador == '>')
                                                    Menos o igual que
                                                @endif
                                                @if($elem->verde_operador == '<')
                                                    Mas o igual que
                                                @endif
                                                @if($elem->verde_operador == '>=')
                                                    Menos de
                                                @endif
                                                @if($elem->verde_operador == '<=')
                                                    Mas de
                                                @endif{{$elem->amarillo}}</td>
                                            @foreach($elem->semaforo as $sem)

                                                <td>{{$sem["numero"]}}</td>

                                            @endforeach
                                        </tr>

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                </div>

            </div>
        </div>
    </div>
@endsection
