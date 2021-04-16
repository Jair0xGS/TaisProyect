@extends('layouts.app')

@section('content')<img src="../../img/tablero.jpg" alt="panda" style="width: 100%; position: relative; float: right">
    <br><br><br><br>
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-md-6">

                <div class="card mt-5" style="background: rgba(255, 255, 255, .04); border-radius: 20px">
                    <div class="row  ml-4" >
                        <div class="text-white" style="font-size: 80px; font-family: Broadway">
                            <span class="text-main font-weight-bold">B</span><span class="text-white font-weight-bold">PM</span>
                        </div>
                        <div><br><br>
                            <span style="color: #e7dfdd;font-size: 20px">Análisis empresarial</span>
                        </div>
                    </div>
                    <hr style="background: whitesmoke;">

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" placeholder="EMAIL" class="form-control @error('email') is-invalid @enderror btn-dark text-white" style="background: #0E0B16;" name="email" value="{{ old('email') }}">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>No hay coincidencias, email erróneo</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" type="password" placeholder="CONTRASEÑA" class="form-control @error('password') is-invalid @enderror btn-dark text-white" style="background: #0E0B16;" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>No hay coincidencias, contraseña errónea</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0 mt-5">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-main btn-block font-weight-bold">
                                        <h4>LOGIN</h4>
                                    </button>

                                    <br><br>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
