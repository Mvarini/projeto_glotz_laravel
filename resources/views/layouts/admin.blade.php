<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{--    <link rel="icon" href="{{ asset('img/icon/favicon.ico') }}" type="image/x-icon"/>--}}

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles_sbadmin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #2dab27; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608;}
    </style>

    <title>Glotz Educação Digital</title>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i>
    </button>

    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="#">Glotz Educação Digital</a>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">{{--<i class="fas fa-user fa-fw"></i>--}}
                @if(auth()->check())
                    @php
                        $partes = explode(' ', auth()->user()->name);
                        $user = array_shift($partes);
                    @endphp
                    {{ $user }}
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Perfil</a></li>
                <li><a class="dropdown-item" href="{{ route('login.destroy') }}">Sair</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    @can('index-dashboard')
                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'dashboard']) class="nav-link"
                           href="{{ route('dashboard.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                    @endcan

                    @can('index-teacher')
                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'teachers']) class="nav-link"
                           href="{{ route('teacher.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                            Professor
                        </a>
                    @endcan
                    @can('index-course')
                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'courses']) class="nav-link"
                           href="{{ route('course.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clapperboard"></i></div>
                            Curso
                        </a>
                    @endcan

                    @can('index-student')
                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'students']) class="nav-link"
                           href="{{ route('student.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></div>
                            Aluno
                        </a>
                    @endcan

                    @can('index-user')
                        <a @class(['nav-link', 'active' => isset($menu) && $menu == 'users']) class="nav-link"
                           href="{{ route('user.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Usuário
                        </a>
                    @endcan

                        @can('index-role')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'roles']) class="nav-link"
                               href="{{ route('role.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-network-wired"></i></div>
                                Papel
                            </a>
                        @endcan

                        @can('index-permission')
                            <a @class(['nav-link', 'active' => isset($menu) && $menu == 'permissions']) class="nav-link" href="{{ route('permission.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-shield-halved"></i></div>
                                Permissão
                            </a>
                        @endcan
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-center small">
                    <div class="text-muted">Glotz Educação Digital {{ date('Y') }} - Todos os direitos
                        reservados
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js/') }}"></script>
<script src="{{ asset('js/scripts_sbadmin.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/mask.js') }}"></script>
<script src="{{ asset('js/sweet.alert.delete.js') }}"></script>

</body>
</html>
