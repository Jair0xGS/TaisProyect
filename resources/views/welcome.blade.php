@extends('layouts.plantilla')

@section('contenido')

    <div class="container">
        <div class="row justify-content-center ">
            <div class="texto-grey" style="font-size: 40px">
                <i class="fas fa-sitemap"></i>
                <span class="font-weight-bold ml-3"  style="font-size: 40px; font-family: Broadway"><span class="text-main">B</span>PM</span>
                <div class="text-dark" style="font-size: 20px">
                    <p>¡Te da la bienvenida!</p>
                </div>

            </div>
        </div>
    </div>
    @if(session('datos'))
        <br>
        <div class="col-12 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
            <strong>ATENCIÓN</strong> {{session('datos')}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="float-rigth col-12">
            <img src="../../img/tablero2.jpg" alt="panda" style="width: 100%; position: relative;">
        </div>
    </div>

@endsection

