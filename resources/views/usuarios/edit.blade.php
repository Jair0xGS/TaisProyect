@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-pen-square color-icono"></i>
            <span class="font-weight-bold ml-3" > EDITAR PERSONAL</span>
        </div><br><br><br>

    </div>
    <div class="container">
        <form method="POST" action="{{route("user.update",$personal->id)}}">
            @method('put')
            @csrf
            <div class="row mb-5">
                <h6 class="ml-4">Haga los cambios que considere necesarios:</h6><br><br>

                <div class="input-group mb-3 col-12 d-none">
                    <input type="text" class="form-control" id="id" name="id" value="{{$personal->id}}" disabled>
                </div>

                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('nombres') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control form-control-alternative{{ $errors->has('nombres') ? ' is-invalid' : '' }}" placeholder="Nombres" value="{{$personal->nombres}}" >

                        @if ($errors->has('nombres'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombres') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('apellidos') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control form-control-alternative{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" placeholder="Apellidos" value="{{$personal->apellidos}}" >

                        @if ($errors->has('apellidos'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('apellidos') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="Teléfono" value="{{$personal->telefono}}" >

                        @if ($errors->has('telefono'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telefono') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('correo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Correo</label>
                        <input type="correo" name="correo" id="correo" class="form-control form-control-alternative{{ $errors->has('correo') ? ' is-invalid' : '' }}" placeholder="Correo" value="{{$personal->correo}}" >

                        @if ($errors->has('correo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('correo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('puesto_id') ? ' has-danger' : '' }} col-lg-8 col-md-12">
                        <label class="form-control-label" for="input-current-password">Puesto (por cubrir)</label>
                        <select class="custom-select form-control-alternative{{ $errors->has('puesto_id') ? ' is-invalid' : '' }}"  name="puesto_id" id="puesto_id">
                            <option value="{{$personal->Puesto->id}}">{{$personal->Puesto->nombre}}</option>
                            @foreach($puestos_por_cubrir as $itm)
                                    @if($itm->area->empresa_id ==Auth::user()->Empresa->id)
                                        <option value="{{$itm->id}}">{{$itm->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('puesto_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('puesto_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <a href="{{URL::to('/user')}}">
                                <i class="fas fa-link color-icono icono"></i>
                                <span class="ml-2" >MOSTRAR PERSONAL</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-12 mb-2">
                            <button type="button" class="btn btn-block text-white font-weight-bold btn-main" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-save icono"></i>
                                GUARDAR CAMBIOS
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header color-degradado text-white">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> </i> ATENCIÓN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center m-3">
                                        ¿Desea confirmar los cambios?
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
                    </div>
                </form><br><br><br><br>
                <div class="mt-5 card p-5  text-center">
                    <button type="button" class="btn btn-block text-white btn-dark" data-toggle="modal" data-target="#modalRestablecer">
                        <i class="fas fa-play"></i>
                        RESTABLECER PASSWORD
                    </button>
                    <!-- Modal RESTABLECER -->
                    <div class="modal fade" id="modalRestablecer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header color-degradado text-white">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> </i> ATENCIÓN</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center m-3">
                                    ¿Seguro que desea restablecer la contraseña del personal seleccionado?
                                </div>
                                <div class="modal-footer row p-0 m-3">
                                    <div class="col-5">
                                        <button type="button" class="btn btn-outline-dark btn-sm btn-block" data-dismiss="modal">NO</button>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-5">
                                        <a href="{{route('user.show',$personal->id)}}" class="btn btn-outline-primary btn-sm btn-block">SÍ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endsection
        @endrole
