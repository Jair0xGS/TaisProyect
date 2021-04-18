@role('admin')

@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-user"></i>
            <span class="font-weight-bold ml-3" >PERSONAL DE LA EMPRESA</span>
        </div><br>
    </div>
    <div style="margin-left: 150px;margin-right: 150px">

        <div class="row">
            <div class="col-md-5 col-sm-12">
                <a href="{{route('user.create')}}">
                    <i class="fas fa-plus-circle color-icono icono"></i>
                    <span class="ml-2" >REGISTRAR PERSONAL</span>
                </a>
            </div>
            <div class="col-md-7 col-sm-12">
                <form class="form-inline float-right">
                    <div class="form-group has-search">

                        <input type="search" placeholder="Buscar PERSONAL" value="{{$buscarpor}}" name="buscarPor" class="form-control mr-sm-2">
                        <button class="btn my-2 my-sm-0 btn-dark float-right" type="submit">BUSCAR</button>
                    </div>
                </form>
            </div>
        </div>

        <br><br>
        @if(session('datos'))
            <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('datos')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(count($personal)>0)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Acción</th>
                </tr>
                </thead>
                <tbody>

                @foreach($personal as $itemPersonal)
                    <tr>
                        <td>{{$itemPersonal->nombres}}</td>
                        <td>{{$itemPersonal->apellidos}}</td>
                        <td>{{$itemPersonal->telefono}}</td>
                        <td>{{$itemPersonal->correo}}</td>
                        <td>{{$itemPersonal->Puesto->nombre}}</td>
                        <td>
                            <div class="color-titulo row" style="font-size: 25px">
                                <a href="{{route('rotacion',$itemPersonal->id)}}" class="col-4 p-0"><i class="fas fa-retweet btn-otro"></i></a>
                                <a href="{{route('user.edit',$itemPersonal->id)}}" class="col-4 p-0"><i class="fas fa-pen-square btn-editar"></i></a>
                                <a href="" data-toggle="modal" data-target="<?php echo "#an".$itemPersonal->id; ?>" class="col-4 p-0"><i class="fas fa-trash-alt btn-eliminar"></i></a>

                            </div>

                            <!-- Modal -->
                            <form method="POST" action="{{route("user.destroy",$itemPersonal->id)}}">
                                @method('delete')
                                @csrf

                                <div class="modal fade" id="<?php echo "an".$itemPersonal->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header color-degradado text-white">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ATENCIÓN</i></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center m-3">
                                                ¿Confirma que desea borrar el personal seleccionado?
                                            </div>
                                            <div class="modal-footer row p-0 m-3">
                                                <div class="col-5">
                                                    <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-dismiss="modal">NO</button>
                                                </div>
                                                <div class="col-1"></div>
                                                <div class="col-5">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm btn-block">SÍ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table><br>
            <div class="row justify-content-center">
                {{$personal->links()}}
            </div>
        @else
            <div class="row">
                <div class="col-12 mb-5 alert alert-info alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                    Sin personal disponible para mostrar...
                </div>
            </div>
        @endif
    </div>

@endsection
@endrole
