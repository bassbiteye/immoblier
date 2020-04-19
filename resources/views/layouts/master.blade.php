<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>ALAWA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-blue navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i style="color:white" class="fas fa-bars" style="color:#0879FA"></i></a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <p style="color:white">
                            {{ __('DECONNEXION') }}
                        </p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            <!-- SEARCH FORM -->


            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-info-info elevation-4 navbar-white ">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="./img/logo.png" alt="laravue Logo" class="brand-image img-circle elevation-3" style="opacity: 8">
                <span class="brand-text font-weight-light">ALAWA</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar  ">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-2 pb-3 mb-3 d-flex navbar-blue ">
                    <div class="image mt-2">
                        <img src="/img/profile//{{ Auth::user()->photo }}" class="img-circle elevation-3" alt="User Image">
                    </div>
                    <div class="info  ">

                        <h4> <a href="/profile" class="d-block mt-2" style="color:white">{{Auth::user()->name}}</a></h4>

                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2 navbar-white">
                    <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link to="/home" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt info" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Tableau de bord
                            </router-link>

                        </li>

                        @can('isAdmin')

                        <li class="nav-item">
                            <router-link to="/bailleurs" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie red" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Bailleurs
                            </router-link>

                        </li>
              
                        <li class="nav-item">
                            <router-link to="/clients" class="nav-link">
                                <i class="nav-icon fas fa-user blue" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Clients
                            </router-link>

                        </li>
                        <li class="nav-item">
                            <router-link to="/typeclients" class="nav-link">
                                <i class="nav-icon fas fa-user yellow" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Type Clients
                            </router-link>

                        </li>          <li class="nav-item">
                            <router-link to="/typeetats" class="nav-link">
                                <i class="nav-icon fas fa-plus-square" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Type Etats
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/typebiens" class="nav-link">
                                <i class="nav-icon fas fa-building blue" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Type Biens
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/typecomptes" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Type Comptes
                            </router-link>
                        </li>
                        

                        <li class="nav-item">
                            <router-link to="/biens" class="nav-link">
                                <i class="nav-icon fas fa-building green" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Biens
                            </router-link>

                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-exchange-alt" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Services
                                    <i class="right fas fa-angle-left" ></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="louer" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="color:#0879FA"></i>

                                        <p style="color:black">location</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="color:#0879FA"></i>
                                        <p style="color:black">Vente</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="color:#0879FA"></i>
                                        <p style="color:black">comptablité</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="color:#0879FA"></i>
                                        <p style="color:black">Gérance</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <i class="fas fa-users nav-icon" style="color:#0879FA"></i>
                                <p style="color:black">
                                    utilisateurs
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon fas fa-user orange" style="color:#0879FA"></i>
                                <p style="color:black">
                                    Profile
                                </p>
                            </router-link>
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                    <vue-progress-bar></vue-progress-bar>

                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->

        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer navbar-blue " style="color:white">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline " style="color:white">
                ALAWA
            </div>
            <!-- Default to the left -->
            <strong style="color:white">Copyright &copy; 2019-2020 <a href="#" style="color:white">www.alawa.com</a></strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    @auth
    <script>
        window.user = @json(auth()->user())
    </script>
    @endauth
    <script src="/js/app.js"></script>
</body>

</html>