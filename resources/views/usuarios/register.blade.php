@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-user"></i>
            <span class="font-weight-bold ml-3" > REGISTRAR PERSONAL</span>
        </div><br><br><br>

    </div>
    <div class="container">
        @if(session('datos'))
            <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('datos')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form method="POST" action="{{route('user.store')}}">
            @csrf
            <div class="row mb-5">
                <h6 class="ml-4">Complete los campos requeridos:</h6><br><br>
                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('nombres') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control form-control-alternative{{ $errors->has('nombres') ? ' is-invalid' : '' }}" placeholder="Nombres" value="{{old('nombres')}}" >

                        @if ($errors->has('nombres'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombres') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('apellidos') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control form-control-alternative{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" placeholder="Apellidos" value="{{old('apellidos')}}" >

                        @if ($errors->has('apellidos'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('apellidos') }}</strong>
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

                    <div class="form-group{{ $errors->has('correo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Correo</label>
                        <input type="correo" name="correo" id="correo" class="form-control form-control-alternative{{ $errors->has('correo') ? ' is-invalid' : '' }}" placeholder="Correo" value="{{old('correo')}}" >

                        @if ($errors->has('correo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('correo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('puesto_id') ? ' has-danger' : '' }} col-lg-8 col-md-12">
                        <label class="form-control-label" for="input-current-password">Puesto (por cubrir)</label>
                        <select class="custom-select form-control-alternative{{ $errors->has('puesto_id') ? ' is-invalid' : '' }}"  name="puesto_id" id="puesto_id">
                            @foreach($puestos_por_cubrir as $itm)
                                <option value="{{$itm->id}}">{{$itm->nombre}}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('puesto_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('puesto_id') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>


            </div><br><br><br><br>

            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <a href="{{URL::to('/user')}}">
                        <i class="fas fa-link color-icono icono"></i>
                        <span class="ml-2" >MOSTRAR PERSONAL</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-6 mb-2">
                    <a href="{{route('cancelarPersonal')}}" class="btn btn-block btn-dark">
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
