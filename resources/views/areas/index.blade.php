@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-bars color-icono"></i>
            <span class="font-weight-bold ml-3" >ÁREAS Y PUESTOS</span>
        </div><br><br><br>

    </div>
    <div class="m-5">

        @if(session('datos'))
            <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('datos')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row ml-5">
            <div class="col-md-6 col-sm-12 ml-5">
                <a href="" data-toggle="modal" data-target="#registrar">
                    <i class="fas fa-plus-circle"></i>
                    <span class="ml-2" >REGISTRAR ÁREA</span>
                </a>

                <!-- Modal -->
                <form method="POST" action="{{route("area.store")}}">
                    @csrf

                    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header color-degradado text-white">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> REGISTRAR ÁREA</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body row">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-12">
                                        <label class="form-control-label" for="input-current-password">Nombre de área</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{old('nombre')}}" required>

                                        @if ($errors->has('nombre'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer row p-0 m-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-main btn-sm btn-block"><i class="fas fa-save"></i> GUARDAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br><br>
        <div class="row justify-content-center">
            @if(count($area)>0)
                @foreach($area as $item)
                    <div class="card col-md-3 col-xs-12 col-sm-5 m-4 p-0">
                        <div class="card-header color-degradado">
                            <h5 class="text-white"><i class="fas fa-clone" style="font-size: 30px"></i> {{$item->nombre}}</h5>
                        </div>
                        <div class="card-body">
                            @foreach($item->puestos as $itm)
                                <ul style=" border-bottom-color:#e3dff8; border-bottom-style:dashed; border-bottom-width:3px;" class="bg-light p-1">
                                    <li>{{$itm->nombre}}
                                        <div class="dropdown" style="float: right">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v text-secondary"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="<?php echo "#editP".$itm->id; ?>"><i class="far fa-edit btn-editar"></i> Editar</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="<?php echo "#deleteP".$itm->id; ?>"><i class="fas fa-trash text-main"></i> Eliminar</a>
                                            </div>
                                            <!-- Modal delete puesto-->
                                            <form method="POST" action="{{route("puesto.destroy",$itm->id)}}">
                                                @method('delete')
                                                @csrf

                                                <div class="modal fade" id="<?php echo "deleteP".$itm->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header text-white color-degradado">
                                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ELIMINAR PUESTO</i></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                ¿Confirma que desea borrar el puesto seleccionado? <br><br>
                                                            </div>
                                                            <div class="modal-footer row p-0 m-3">
                                                                <div class="col-5">
                                                                    <button type="button" class="btn btn-outline-dark btn-sm btn-block" data-dismiss="modal">NO</button>
                                                                </div>
                                                                <div class="col-1"></div>
                                                                <div class="col-5">
                                                                    <button type="submit" class="btn btn-outline-primary btn-sm btn-block">SÍ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Modal edit puesto-->
                                            <form method="POST" action="{{route("puesto.update",$itm->id)}}">
                                                @method('put')
                                                @csrf

                                                <div class="modal fade" id="<?php echo "editP".$itm->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header color-degradado text-white">
                                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> EDITAR PUESTO</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body row">
                                                                <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-12">
                                                                    <label class="form-control-label" for="input-current-password">Nombre de puesto</label>
                                                                    <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{$itm->nombre}}" required>

                                                                    @if ($errors->has('nombre'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('nombre') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer row p-0 m-3">
                                                                <div class="col-12">
                                                                    <button type="submit" class="btn btn-main btn-sm btn-block"><i class="fas fa-save"></i> GUARDAR CAMBIOS</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <div class="row pl-3 text-center" style="font-size: 25px">
                                <a href="" data-toggle="modal" data-target="<?php echo "#registerP".$item->id; ?>" class="col-4"><i class="fas fa-plus-circle text-dark"></i></a>
                                <a href="" data-toggle="modal" data-target="<?php echo "#edit".$item->id; ?>" class="col-4"><i class="fas fa-pen-square btn-editar"></i></a>
                                <a href="" data-toggle="modal" data-target="<?php echo "#delete".$item->id; ?>" class="col-4"><i class="fas fa-trash-alt btn-borrar"></i></a>

                            </div>
                            <!-- Modal registrar puesto -->
                            <form method="POST" action="{{route("puesto.store")}}">
                                @csrf

                                <div class="modal fade" id="<?php echo "registerP".$item->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header color-degradado text-white">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> REGISTRAR PUESTO</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-12">
                                                    <label class="form-control-label" for="input-current-password">Nombre de puesto</label>
                                                    <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{old('nombre')}}" required>
                                                    <input type="text" name="area_id" id="area_id" value="{{$item->id}}" class="d-none">

                                                    @if ($errors->has('nombre'))
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer row p-0 m-3">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-main btn-sm btn-block"><i class="fas fa-save"></i> GUARDAR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Modal delete area-->
                            <form method="POST" action="{{route("area.destroy",$item->id)}}">
                                @method('delete')
                                @csrf

                                <div class="modal fade" id="<?php echo "delete".$item->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-white color-degradado">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ELIMINAR ÁREA</i></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                ¿Confirma que desea borrar el área seleccionado? <br><br>

                                                <div class="d-none">
                                                    <input class="form-control" id="empresa" name="empresa" rows="4" value="{{$em}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer row p-0 m-3">
                                                <div class="col-5">
                                                    <button type="button" class="btn btn-outline-dark btn-sm btn-block" data-dismiss="modal">NO</button>
                                                </div>
                                                <div class="col-1"></div>
                                                <div class="col-5">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm btn-block">SÍ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Modal edit area-->
                            <form method="POST" action="{{route("area.update",$item->id)}}">
                                @method('put')
                                @csrf

                                <div class="modal fade" id="<?php echo "edit".$item->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header color-degradado text-white">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> EDITAR ÁREA</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-12">
                                                    <label class="form-control-label" for="input-current-password">Nombre de área</label>
                                                    <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{$item->nombre}}" required>

                                                    @if ($errors->has('nombre'))
                                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer row p-0 m-3">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-main btn-sm btn-block"><i class="fas fa-save"></i> GUARDAR CAMBIOS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
                <br><br>
        </div><br><br><br>
        <div class="row justify-content-center">
            {{$area->links()}}
        </div>

        @else
            <div class="col-12 m-5 alert alert-info alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                Sin áreas disponibles para mostrar...
            </div>
        @endif
        <br><br>

    </div>

@endsection

@endrole
