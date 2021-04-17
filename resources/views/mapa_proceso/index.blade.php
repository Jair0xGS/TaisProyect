@extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="color-titulo m-5" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" >MAPA PROCESOS</span>
            </div>
        </div>
        <div class="row mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-10">

                    </div>
                    <div class="col-2 mb-3">
                        <a href="{{route('mapa_proceso.create',Request()->empresa)}}" class="btn btn-primary" role="button" aria-pressed="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Mapa Proceso
                        </a>
                    </div>
                </div>
                <div class="row">



                            @foreach($data as $elem)
                                @if($elem->tipoProceso != null)
                            <div class="col col-4">
                                <div class="card">
                                    <h5 class="card-header">Featured</h5>
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
