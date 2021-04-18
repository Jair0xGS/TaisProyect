@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-pen-square color-icono"></i>
            <span class="font-weight-bold ml-3" > INTERCAMBIO DE PUESTOS</span>
        </div><br>

    </div>
    <div class="row ml-5">
        <div class="col-md-9 col-sm-12">
            <a href="{{URL::to('/user')}}">
                <i class="fas fa-link color-icono icono"></i>
                <span class="ml-2" >MOSTRAR PERSONAL</span>
            </a>
        </div>
    </div><br><br>
    <div class="m-5">

            <div class="row justify-content-center">
                @foreach($personal as $item)
                <div class=" card col-md-2 col-sm-12 m-3 color-degradado text-center">
                    <div class="card-header bg-dark"></div>
                    <span class="text-white">
                        {{$item->nombres}} {{$item->apellidos}}<br> {{$item->Puesto->nombre}}
                    </span><br>
                    <button type="button" class="btn btn-block font-weight-bold btn-light btn-sm" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-check"></i>
                    </button>
                    <br>
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
                                ¿Desea confirmar el intercambio de puestos?
                            </div>
                            <div class="modal-footer row p-0 m-3">
                                <div class="col-5">
                                    <button type="button" class="btn btn-outline-dark btn-sm btn-block" data-dismiss="modal">NO</button>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <a href="{{route('intercambio',array($id,$item->id))}}" class="btn btn-outline-primary btn-sm btn-block">SÍ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>

@endsection
@endrole
