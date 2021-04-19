@role('admin')

@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fab fa-gitter"></i>
            <span class="font-weight-bold ml-3" >MATRIZ DE INDICADORES POR PROCESO</span>
        </div><br>
    </div>
    <div style="margin-left: 150px;margin-right: 150px">

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <a href="{{route('indicador.create')}}">
                    <i class="fas fa-plus-circle"></i>
                    <span class="ml-2" >REGISTRAR INDICADOR</span>
                </a>
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

        @if(count($proceso)>0)


                    <table class="table table-hover text-center" border="1">
                        <thead>
                            <tr class="color-degradado text-white">
                                <th colspan="2">MACROPROCESO/PROCESO</th>
                                <th colspan="6">INDICADORES</th>
                            </tr>
                            <tr>
                                <th>NOMBRE</th>
                                <th>RESPONSABLE</th>
                                <th>SUBPROCESO</th>
                                <th>CÓDIGO</th>
                                <th>DENOMINACIÓN</th>
                                <th>UNIDAD</th>
                                <th>RESPONSABLE</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($proceso as $itemProceso)
                            @php $c =0; @endphp
                                @foreach($itemProceso->procesos as $i)
                                    @php
                                        $num = 0;
                                        if(count($i->indicadores)==0)
                                            $num = 1;
                                        else
                                            $num = count($i->indicadores);
                                        $c = $c + $num;
                                    @endphp
                                @endforeach

                    <tr>
                        <td @if(count($itemProceso->procesos)==0)
                                @if(count($itemProceso->indicadores)!=0)
                                    rowspan="{{count($itemProceso->indicadores)}}"
                                @else
                                    rowspan="1"
                                @endif
                            @else
                                @if(count($itemProceso->indicadores)!=0)
                                    rowspan="{{$c+count($itemProceso->indicadores)}}"
                                @else
                                    rowspan="{{$c+1}}"
                                @endif
                            @endif>
                            {{$itemProceso->nombre}}
                        </td>
                        <td @if(count($itemProceso->procesos)==0)
                                @if(count($itemProceso->indicadores)!=0)
                                    rowspan="{{count($itemProceso->indicadores)}}"
                                @else
                                rowspan="1"
                                @endif
                            @else
                                @if(count($itemProceso->indicadores)!=0)
                                    rowspan="{{$c+count($itemProceso->indicadores)}}"
                                @else
                                    rowspan="{{$c+1}}"
                                @endif
                            @endif>
                            {{$itemProceso->personal->nombres}} {{$itemProceso->personal->apellidos}} <br> {{$itemProceso->personal->puesto->nombre}}
                        </td>

                            <td @if(count($itemProceso->indicadores)==0) rowspan="1" @else rowspan="{{count($itemProceso->indicadores)}}" @endif>-</td>
                            @if(count($itemProceso->indicadores)==0)
                                <td colspan="5">Sin indicadores del proceso resgistrados...</td></tr>
                            @else
                        @foreach($itemProceso->indicadores as $itm)
                            <td>{{$itm->id}}</td>
                            <td>{{$itm->descripcion}}</td>
                            <td>{{$itm->unidad}}</td>
                            <td>{{$itm->personal->nombres}} {{$itm->personal->apellidos}} <br>{{$itm->personal->puesto->nombre}}</td>
                            <td>
                                <div class="color-titulo row" style="font-size: 25px">
                                    <a href="{{route('indicador.edit',$itm->id)}}" class="col-6 p-0"><i class="fas fa-pen-square btn-editar"></i></a>
                                    <a href="" data-toggle="modal" data-target="<?php echo "#an".$itm->id; ?>" class="col-6 p-0"><i class="fas fa-trash-alt btn-eliminar"></i></a>
                                </div>

                                <!-- Modal -->
                                <form method="POST" action="{{route("indicador.destroy",$itm->id)}}">
                                    @method('delete')
                                    @csrf

                                    <div class="modal fade" id="<?php echo "an".$itm->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header color-degradado text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ATENCIÓN</i></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center m-3">
                                                    ¿Confirma que desea borrar el registro seleccionado?
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
                            </td></tr>
                            @endforeach

                            @endif

                        @foreach($itemProceso->procesos as $item)
                            <td @if(count($item->indicadores)==0) rowspan="1" @else rowspan="{{count($item->indicadores)}}" @endif>{{$item->nombre}}</td>
                            @if(count($item->indicadores)==0)
                                <td colspan="5">Sin indicadores resgistrados...</td></tr>
                            @else
                                @foreach($item->indicadores as $itm)
                                    <td>{{$itm->id}}</td>
                                    <td>{{$itm->descripcion}}</td>
                                    <td>{{$itm->unidad}}</td>
                                    <td>{{$itm->personal->nombres}} {{$itm->personal->apellidos}} <br>{{$itm->personal->puesto->nombre}}</td>
                                    <td>
                                        <div class="color-titulo row" style="font-size: 25px">
                                            <a href="{{route('indicador.edit',$itm->id)}}" class="col-6 p-0"><i class="fas fa-pen-square btn-editar"></i></a>
                                            <a href="" data-toggle="modal" data-target="<?php echo "#an".$itm->id; ?>" class="col-6 p-0"><i class="fas fa-trash-alt btn-eliminar"></i></a>
                                        </div>

                                        <!-- Modal -->
                                        <form method="POST" action="{{route("indicador.destroy",$itm->id)}}">
                                            @method('delete')
                                            @csrf

                                            <div class="modal fade" id="<?php echo "an".$itm->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header color-degradado text-white">
                                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"> ATENCIÓN</i></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center m-3">
                                                            ¿Confirma que desea borrar el registro seleccionado?
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

                            @endif
                        @endforeach
                @endforeach
                </tbody>
            </table><br><br>

        @else
            <div class="row">
                <div class="col-12 mb-5 alert alert-info alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                    Sin procesos disponibles para mostrar...
                </div>
            </div>
        @endif
    </div>

@endsection
@endrole

