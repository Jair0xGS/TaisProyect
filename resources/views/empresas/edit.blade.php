@role('super_admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-pen-square color-icono"></i>
            <span class="font-weight-bold ml-3" > EDITAR EMPRESA</span>
        </div><br><br><br>

    </div>
    <div class="container">
        <form method="POST" action="{{route("empresa.update",$empresa->id)}}">
            @method('put')
            @csrf
            <div class="row mb-5">
                <h6 class="ml-4">Haga los cambios que considere necesarios:</h6><br><br>

                <div class="input-group mb-3 col-12 d-none">
                    <input type="text" class="form-control" id="id" name="id" value="{{$empresa->id}}" disabled>
                </div>

                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('ruc') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">RUC</label>
                        <input type="text" name="ruc" id="ruc" class="form-control form-control-alternative{{ $errors->has('ruc') ? ' is-invalid' : '' }}" placeholder="RUC" value="{{$empresa->ruc}}" >

                        @if ($errors->has('ruc'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ruc') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{$empresa->nombre}}" >

                        @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control form-control-alternative{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" placeholder="Descripción" value="{{$empresa->descripcion}}" >

                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="Teléfono" value="{{$empresa->telefono}}" >

                        @if ($errors->has('telefono'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telefono') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{$empresa->email}}" >

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control form-control-alternative{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="Dirección" value="{{$empresa->direccion}}" >

                        @if ($errors->has('direccion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('direccion') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div><br><br><br><br>


            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <a href="{{URL::to('/empresa')}}">
                        <i class="fas fa-link color-icono icono"></i>
                        <span class="ml-2" >MOSTRAR EMPRESAS</span>
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
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ATENCIÓN</i></h5>
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
        </form>
    </div>

@endsection
@endrole
