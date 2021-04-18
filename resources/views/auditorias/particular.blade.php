@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="container">
        <div class="row justify-content-center ">
            <div class="texto-grey m-5 text-center" style="font-size: 40px">
                <i class="fas fa-sitemap"></i>
                <span class="font-weight-bold ml-3" ><span class="text-main">B</span>PM</span>
                <div class="text-dark" style="font-size: 20px">
                    <p>Historial de actividades</p>
                </div>

            </div>
        </div>
    </div>
    <div class="row m-5 pb-3" style=" border-bottom-color:#7ccfe8; border-bottom-style:dashed; border-bottom-width:2px;">

        <div class="col-md-6 col-sm-12">
            <form class="form-inline my-2 my-lg-0">
                <div class="form-group has-search">
                    <label for="name" class="col-form-label">Inicio: </label>
                    <input id="dateInicio" name="dateInicio" width="276" value="{{$inicio}}" />
                    <label for="name" class="col-form-label ml-3">Fin: </label>
                    <input id="dateFin" name="dateFin" width="276" value="{{$fin}}" />
                    <button class="btn my-2 my-sm-0 btn-dark float-right" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-6 col-sm-12">
            <form class="form-inline my-2 my-lg-0 float-right">
                <div class="form-group has-search">
                    <input type="search" placeholder="Buscar por USUARIO" value="{{$buscarpor}}" name="buscarPor" class="form-control mr-sm-2">
                    <button class="btn my-2 my-sm-0 btn-main float-right" type="submit">BUSCAR</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row m-5">
        @if(session('mensaje'))
            <div class="col-12 mb-3 alert alert-danger alert-dismissible fade show" role="alert" style="position: relative; width:100%">
                <strong>ATENCIÓN</strong> {{session('mensaje')}}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>TABLA</th>
                <th>ACCIÓN</th>
                <th>TERMINAL</th>
                <th>USUARIO</th>
                <th>FECHA</th>
                <th>PROPIEDADES</th>
            </tr>
            @foreach($auditoria as $item)

                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->tabla}}</td>
                    <td>{{$item->accion}}</td>
                    <td>{{$item->terminal}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->created_at}}</td>

                    <td><a class="btn btn-sm btn-dark text-white" data-toggle="modal" data-target="<?php echo "#p".$item->id; ?>">PROPIEDADES</a></td>
                    <!-- Modal -->
                    <div class="modal fade" id="<?php echo "p".$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-dark btn-light">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> PROPIEDADES</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="row">

                                        @php
                                            $c=0;
                                        @endphp
                                        @if($item->despues!=null)

                                            <div class="col-12 p-3" style="background: #9cc9ff">
                                                <p>DATOS NUEVOS</p>
                                                @foreach(json_decode($item->despues) as $key => $val)
                                                    <div class="card" style="color: black"> <?php echo strtoupper($key)?>: {{$val}}</div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($item->antes!=null)

                                            <div class="col-12 color-degradado p-3">
                                                <p>DATOS ANTIGUOS</p>
                                                @foreach(json_decode($item->antes) as $key => $val)
                                                    <div class="card" style="color: black"><?php echo strtoupper($key)?>: {{$val}}</div>
                                                @endforeach
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </tr>
            @endforeach
        </table>
    </div>
    <div class="row justify-content-center">
        {{$auditoria->links()}}
    </div>
    <script>
        $('#dateInicio').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
        });
        $('#dateFin').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
        });
    </script>

@endsection

@endrole
