<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('name') </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet"
          href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
    <style>
        .jola {
            height: 100px;
        }
        .btn-verde {
            background: #8BD257 !important;
            color: white !important;
        }

        .btn-morado-oscuro {
            background: #250a48 !important;
        }

        .btn-amarillo {
            background: #f5c64a !important;
        }

        .btn-celeste {
            background: #00becc !important;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light btn-verde">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link p-0 pl-2 m-0" style="background-color: white;">
            <i class="fas fa-th-large text-verde-osc ml-2"></i>
            <span class="brand-text font-weight-light m-0 ml-3 p-0">
                    <img class="logo" src="{{ asset('img/aunor.jpg') }}" alt="Card image cap" width="150px">
                </span>
        </a>
        <div>
            <div class="brand-link user-panel d-flex btn-white text-dark">
                    <span class="brand-text info w-100 text-center mt-1 btn-white">
                        <div style="font-size:20px" class=" row justify-content-center mb-1">
                            <div class="rounded-circle font-weight-bold text-gray" style="background:#e9eceb; width:35px">
                                <?php echo Str::upper(substr(Auth::user()->name, 0,1))?>
                            </div>
                        </div>
                        <h6 class="font-weight-light text-dark">{{ Auth::user()->email}}</h6>
                    </span>
            </div>
        </div>


        <!-- Sidebar -->
        <div class="sidebar" style="background-color: #fff;">

            <!-- Sidebar Menu -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false" >
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    @role('admin')

                    @endrole
                    @role('user')

                    @endrole
                    <li class="nav-item ">
                        <a href="#" class="nav-link text-celeste">
                            <i class="mr-2 fas fa-users"></i>
                            <p>
                                METAS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3 mr-1">
                            <li class="nav-item btn-light " >
                                <a href="{{route('meta.activa')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>ACTIVAS</p>
                                </a>
                            </li>
                            <li class="nav-item btn-light" >
                                <a href="{{route('meta.index')}}" class="nav-link text-gray">
                                    <i class="fas fa-plus-square mr-2"></i>
                                    <p>PENDIENTES</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link text-celeste">
                            <i class="mr-2 fas fa-file-alt"></i>
                            <p>
                                ESTRATEGIAS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3 mr-1">
                            <li class="nav-item btn-light" >
                                <a href="{{route('estrategia.activa')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>IMPLEMENTADAS</p>
                                </a>
                            </li>
                            <li class="nav-item btn-light" >
                                <a href="{{route('estrategia.index')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>PENDIENTES</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="" class="nav-link text-celeste">
                            <i class="mr-2 fas fa-cog"></i>
                            <p>
                                INVERSIONES
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3 mr-1">
                            <li class="nav-item btn-light" >
                                <a href="{{route('inversion.activa')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>ACTIVAS</p>
                                </a>
                            </li>
                            <li class="nav-item btn-light" >
                                <a href="{{route('inversion.index')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>PENDIENTES</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link text-celeste">
                            <i class="mr-2 fas fa-file-alt"></i>
                            <p>
                                PLAN COMUNICACION
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3 mr-1">
                            <li class="nav-item btn-light" >
                                <a href="{{route('plan.index')}}" class="nav-link text-gray">
                                    <i class="fas fa-eye mr-2"></i>
                                    <p>INTERNA</p>
                                </a>
                            </li>

                        </ul>
                    </li>



                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <main class="content-wrapper pb-2">
        @include('layouts.messages')
        @yield('content')
    </main>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<footer class="main-footer ">
    <strong>Copyright &copy; 2021 <a href="/">Autopista del Norte</a>.</strong>
    Todos los derechos reservados
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
</script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
</script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('js/pages/dashboard.js') }}"></script>

@yield('script')
</body>

</html>
