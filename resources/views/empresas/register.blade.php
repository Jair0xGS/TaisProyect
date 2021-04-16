@role('super_admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-briefcase color-icono"></i>
            <span class="font-weight-bold ml-3" > REGISTRAR EMPRESA</span>
        </div><br><br><br>

    </div>
    <div class="container">
        <form method="POST" action="{{route('empresa.store')}}">
            @csrf
            <div class="row mb-5">
                <h6 class="ml-4">Complete los campos requeridos:</h6><br><br>
                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('ruc') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">RUC</label>
                        <input type="text" name="ruc" id="ruc" class="form-control form-control-alternative{{ $errors->has('ruc') ? ' is-invalid' : '' }}" placeholder="RUC" value="{{old('ruc')}}" >

                        @if ($errors->has('ruc'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ruc') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{old('nombre')}}" >

                        @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control form-control-alternative{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" placeholder="Descripción" value="{{old('descripcion')}}" >

                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="Teléfono" value="{{old('telefono')}}" >

                        @if ($errors->has('telefono'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telefono') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{old('email')}}" >

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control form-control-alternative{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="Dirección" value="{{old('direccion')}}" >

                        @if ($errors->has('direccion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('direccion') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>


            </div><br><br><br><br>

            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <a href="{{URL::to('/empresa')}}">
                        <i class="fas fa-link color-icono icono"></i>
                        <span class="ml-2" >MOSTRAR EMPRESAS</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-6 mb-2">
                    <a href="{{route('cancelarEmpresa')}}" class="btn btn-block btn-dark">
                        CANCELAR
                    </a>
                </div>
                <div class="col-md-2 col-sm-6 mb-2">
                    <button type="submit" class="btn btn-block font-weight-bold btn-main">
                        REGISTRAR
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection
@endrole

