 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAIS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminLte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/adminLte/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .color-degradado{
            background: #0E0B16;

        }

        .btn-main{
            background: #4717F6;
            color: white;
            font-family: "Corbel Light";
        }
        .btn-main:hover{
            background: #110344;
            color: white;
            font-family: "Corbel Light";
        }

        .text-main{
            color: #4717F6;
        }

        .btn-editar{
            color: #2ba1b1;
        }
        .btn-editar:hover{
            color: #06636c;
        }
        .btn-eliminar{
            color: #4717F6;
        }
        .btn-eliminar:hover{
            color: #050f6a;
        }
        .btn-otro{
            color: #03242a;
        }
        .btn-otro:hover{
            color: #06781f;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="https://unpkg.com/docx@6.0.0/build/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/src/FileSaver.js"></script>
</head>
<body class="hold-transition sidebar-mini">
    <script src="{{asset("js/jspdf.umd.min.js")}}"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

    <!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light color-main ">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
        @guest
            <!--<li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
                -->
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: #4717F6;">
                        {{ Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item font-weight-bold" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <div class="row justify-content-center">
                                <div class="text-red">
                                    <i class="fas fa-sign-out-alt"></i> <span class="ml-2">SALIR</span>
                                </div>
                            </div>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary color-degradado elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('home')}}" class="brand-link" style="font-size: 22px">
            <i class="fas fa-sitemap text-white ml-3"></i>
            <span class="brand-text font-weight-light font-weight-bold ml-3" style="font-size: 30px; color: #dcdcdc;font-family: Broadway;">
                <span class="font-weight-bold" style="color: #5973ec">B</span><span class="font-weight-bold">PM</span>
            </span>

            <br>
        </a>

        <!-- Sidebar -->
        <div class="sidebar color-degradado">
            <!-- Sidebar rol (optional) -->
            <div class="user-panel mt-1 pb-3 mb-1 d-flex">
                <div class="info w-100 text-center bg-main"><br>
                    <div style="font-size:25px" class=" row justify-content-center">
                        <div class="rounded-circle font-weight-bold" style="width:45px; background: #a9b3f6">
                            <?php echo substr(Auth::user()->name, 0,1)?>
                        </div>
                    </div>
                    <br>
                    <h6 class="font-weight-light text-white">{{ Auth::user()->email}}</h6>

                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2 color-degradado">

                            @role('super_admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-braille"></i>
                                        <p>
                                            EMPRESAS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{URL::to('/empresa')}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('empresa.create')}}" class="nav-link offset-1">
                                                <i class="far fa-plus-square nav-icon"></i>
                                                <p>Registrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>
                            </ul>
                            @endrole
                            @role('admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            ÁREAS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{URL::to('/area')}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            PROCESOS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{route("proceso.index",Auth::user()->Empresa->id)}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-cogs"></i>
                                        <p>
                                            INDICADORES
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{URL::to('/indicador')}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            PERSONAL
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{URL::to('/user')}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('user.create')}}" class="nav-link offset-1">
                                                <i class="far fa-plus-square nav-icon"></i>
                                                <p>Registrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('super_admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            USUARIOS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('user')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-bars"></i>
                                        <p>
                                            INCIDENCIAS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="" class="nav-link offset-1">
                                                <i class="fas fa-cog nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link offset-1">
                                                <i class="fas fa-cog nav-icon"></i>
                                                <p>Registrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>
                            @endrole
                            @role('super_admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>
                                            AUDITORIAS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{URL::to('/auditoria')}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            @endrole
                            @role('admin')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="" class="nav-link">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>
                                            AUDITORIAS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{route('auditoria.show',Auth::user()->Empresa->id)}}" class="nav-link offset-1">
                                                <i class="fas fa-eye nav-icon"></i>
                                                <p>Mostrar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            @endrole


                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                                    with font-awesome or any other icon font library -->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            PERFIL
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="" class="nav-link offset-1">
                                                <i class="fas fa-pen-square nav-icon"></i>
                                                <p>Editar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link offset-1">
                                                <i class="far fa-eye nav-icon"></i>
                                                <p>Ver</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>

                            </ul>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            @include('layouts.messages')
            @yield('contenido')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2020 <a href="#"></a><i class="fas fa-sitemap ml-4"></i>
            <span class="brand-text font-weight-light font-weight-bold ml-1 mr-3" >BPM</span></strong> Todos los derechos
        reservados
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminLte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminLte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminLte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminLte/dist/js/demo.js"></script>
@yield('js')
</body>
</html>
