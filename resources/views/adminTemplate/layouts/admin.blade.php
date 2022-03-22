@php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
@endphp

<!doctype html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Dentalife" />
    <meta name="description" content="Sistema de control de citas Dentalife" />
    <meta name="author" content="Systemzone" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    @if (!empty($title_template))
        <title>{{ $title_template }}</title>
    @else
        <title>Dentalife</title>
    @endif
    <link rel="shortcut icon" href="{{asset('favicon.png?r='.rand())}}" />
    @if ( isset(auth()->user()->register) && auth()->user()->register == 1)
        <style>
            a.scroll-top {
                display: none;
                width: 40px;
                height: 50px;
                position: fixed;
                z-index: 1000;
                bottom: 50px;
                right: 30px;
                padding-right:20px;
                font-size: 25px;
                border-radius: 3px !important;
                text-align: center;
            }
            a.scroll-top i {
                position: relative;
                top: 5px;
                left: 2px;
                padding-bottom:20px;
            }
            @media  (max-width: 1203px){
                a.scroll-top i {
                    position: relative;
                    top: 5px;
                    padding-left:5px;
                }
            }
        </style>
    @endif


    {{-- Incluir vista donde se encuentran las funciones de javascript que usara el sistema --}}
    @include('adminTemplate.layouts.assets.estilos_css')

    @yield('extracss')
    @stack('extracss')
    @show
    @php
        $item = \Session::get('item');
    @endphp
</head>
<body class= antialiased">
    @auth
    @if (!in_array($item,['2.1:']))
        <div id="contenedor_carga">
            <div id="loader-container">
                <p id="loadingText">Cargando...</p>
            </div>
        </div>
    @endif

    <div class="page">
        <div class="flex-fill">
            <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark sticky-top" >
                <div class="container-fluid">
                    {{-- ========================================================================================= --}}
                    {{--                           HEADER PARA PANTALLAS PEQUEÑAS MENU VERTICAL                    --}}
                    {{-- ========================================================================================= --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand ">
                        <img src="{{ asset('logo2.png') }}" alt="Samaritan's Purse" style='width:160px; height:64px;' class="navbar-brand-image">
                    </h1>

                    <div class="navbar-nav flex-row d-lg-none">
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a class="nav-link px-0" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6a7.75 7.75 0 1 0 10 0" /><line x1="12" y1="4" x2="12" y2="12" />
                                </svg>
                            </a>
                        </div>

                        <div class="nav-item dropdown me-3">
                            <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1" aria-label="Mostrar motificaciones">
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /><path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" /><path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />
                                </svg>

                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <span class="dropdown-item dropdown-header">Notificaciones - {{ date("d/m/Y H:i") }}</span>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item" >
                                    No tiene Notificaciones nuevas
                                </a>
                            </div>
                        </div>

                        <div class="nav-item dropdown drop-avatar">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown" aria-label="Open user menu">
                                <span class="avatar avatar-sm" style="background-image: url({{ imageRouteAvatar(auth()->user()->avatar,1) }})"></span>
                                <svg class="icon " width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow ">
                                <a class="dropdown-item" id="infousersm" style="border-bottom: 1px solid rgba(53, 64, 82, .5184) !important; margin-bottom:10px;display:none">
                                    <div style="font-weight: bold; text-align:center">
                                        {{ Auth::user()->name." ".Auth::user()->ap_paterno}} <br>
                                        <span class="small">{{ Auth::user()->cargo}} </span>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="/perfil_usuario">
                                    <i class="fe fe-user icon dropdown-item-icon"></i>
                                    Perfil de usuario
                                </a>
                                <a class="dropdown-item cursor-pointer bntCerrarSesion">
                                    <i class="fe fe-log-out icon dropdown-item-icon iconCerrarSesion"></i>
                                    <span class="textCerrarSesion">
                                        Cerrar sesión
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- ========================================================================================= --}}
                    {{--                                    MENU SIDEBAR                                           --}}
                    {{-- ========================================================================================= --}}
                    <div class="collapse navbar-collapse navbar-right" id="navbar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item {!!strstr($item,'.',true)=='0' ? 'active' : ''; !!}">
                                <a class="dropdown-item" href="/home">
                                    <span class="nav-link-icon  d-lg-inline-block">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Inicio
                                    </span>
                                </a>
                            </li>

                            {{-- =================================================================================================================== --}}
                            {{--                                              CONTROL DE CITAS                                                       --}}
                            {{-- =================================================================================================================== --}}
                            <li class="nav-item {!!strstr($item,'.',true)=='1'?'active':'';!!}">
                                <a class="dropdown-item" href="/citas" >
                                    <span class="nav-link-icon  d-lg-inline-block">
                                        <i class="fas fa-clipboard-list icon"></i>
                                    </span>
                                    <span class="nav-link-title">
                                        Control de citas
                                    </span>
                                </a>
                            </li>
                            {{-- =================================================================================================================== --}}
                            {{--                                                  USUARIOS                                                           --}}
                            {{-- =================================================================================================================== --}}
                            <li class="nav-item {!!strstr($item,'.',true)=='2'?'active':'';!!}">
                                <a class="dropdown-item" href="/usuarios" >
                                    <span class="nav-link-icon  d-lg-inline-block">
                                        <i class="fa fa-users"></i>
                                    </span>
                                    <span class="nav-link-title">
                                        Usuarios
                                    </span>
                                </a>
                            </li>
                            {{-- =================================================================================================================== --}}
                            {{--                                                    ROLES                                                            --}}
                            {{-- =================================================================================================================== --}}
                            <li class="nav-item {!!strstr($item,'.',true)=='3' ? 'active' : '' ;!!}">
                                <a class="dropdown-item" href="/roles" >
                                    <span class="nav-link-icon  d-lg-inline-block">
                                        <img src="{{asset('icons/role.svg')}}" width="20" height="20" style="{!!strstr($item,'.',true)=='3' ? 'filter: invert(57%) sepia(50%) saturate(468%) hue-rotate(134deg) brightness(101%) contrast(97%);' : 'filter: brightness(0) invert(1);'; !!}">
                                    </span>
                                    <span class="nav-link-title">
                                        Roles &ensp;
                                    </span>
                                </a>
                            </li>
                            {{-- =================================================================================================================== --}}
                            {{--                                                DENTALIFE                                                            --}}
                            {{-- =================================================================================================================== --}}
                            <li class="nav-item {!!strstr($item,'.',true)=='4'?'active':'';!!}">
                                <a class="dropdown-item" href="/especialidades" >
                                    <span class="nav-link-icon  d-lg-inline-block">
                                        <img src="{{asset('icons/tooth.png')}}" width="20" height="20" style="{!!strstr($item,'.',true)=='4' ? 'filter: invert(57%) sepia(50%) saturate(468%) hue-rotate(134deg) brightness(101%) contrast(97%);' : 'filter: brightness(0) invert(1);'; !!}>
                                    </span>
                                    <span class="nav-link-title">
                                        Especialidades &ensp;
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- Cabecera donde se encuentran el logo de empresa y menu de usuario - MENU VERTICAL --}}
<div class="sticky-top">
    <header class="navbar navbar-expand-md navbar-dark d-none d-lg-flex d-print-none" style="background-color: #3FBBC0 !important">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1" aria-label="Mostrar motificaciones">
                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /><path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" /><path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <span class="dropdown-item dropdown-header">Notificaciones - {{ date("d/m/Y H:i") }}</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" >
                            No tiene Notificaciones nuevas
                        </a>
                    </div>
                </div>
                <div class="nav-item me-3 divIconLogout" style="display:none">
                    <a class="nav-link px-0 cursor-pointer logoutModal" data-toggle="tooltipLogout"  title="Cerrar sesión">
                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6a7.75 7.75 0 1 0 10 0" /><line x1="12" y1="4" x2="12" y2="12" />
                        </svg>
                    </a>
                </div>
                <div class="nav-item dropdown ">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm " style="background-image: url({{ imageRouteAvatar(auth()->user()->avatar,1) }})"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div class="font-weight-bold">{{ Auth::user()->name." ".Auth::user()->ap_paterno}}</div>
                            <div class="d-flex mt-2 small text-muted font-weight-bold">
                                <div class="mr-auto">{{ Auth::user()->cargo}}</div>
                                <div>
                                    <svg class="icon icon-avatar" width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a class="dropdown-item" id="infousersm" style="border-bottom: 1px solid rgba(53, 64, 82, .5184) !important; margin-bottom:10px;display:none">
                            <div style="font-weight: bold; text-align:center">
                                {{ Auth::user()->name." ".Auth::user()->ap_paterno}} <br>
                                <span class="small">{{ Auth::user()->cargo}} </span>
                            </div>
                        </a>
                        {{-- @if(Gate::check('users.profile')) --}}
                            <a class="dropdown-item" href="/perfil_usuario">
                                <i class="fe fe-user icon dropdown-item-icon"></i>
                                Perfil de usuario
                            </a>
                        {{-- @endif --}}
                        <a class="dropdown-item cursor-pointer bntCerrarSesion">
                            <i class="fe fe-log-out icon dropdown-item-icon iconCerrarSesion"></i>
                            <span class="textCerrarSesion">
                                Cerrar sesión
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse" id="navbar-menu"></div>
        </div>
    </header>
</div>


            <div class="content">
                <div class="container-fluid">
                    <div class="page-header d-print-none">
                        <div class="row align-items-center">
                            @yield('contenidoHeader')
                        </div>
                    </div>
                    <div class="row row-deck row-cards" id="div_gral_contenido">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @yield('contenido')
                                </div>
                            </div>
                        </div>
                        <a href="#" class="scroll-top" title="Ir arriba">
                            <i class="fa fa-angle-up"></i>
                        </a>
                    </div>
                </div>
                @include('adminTemplate.layouts.sections.footer')
            </div>
        </div>
    </div>

    {{-- modal de cerrar sesión --}}
    <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalCerrarSesion" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-primary"></div>
                <div class="modal-body text-center pt-4 pb-2">
                    <svg class="icon mb-2 text-primary icon-lg" width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                    </svg>
                    <h3>¿Está seguro de cerrar sesión?</h3>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a class="btn @if(themeMode() == 'D') btn-secondary @endif w-100" data-dismiss="modal">
                                    Cancelar
                                </a>
                            </div>
                            <div class="col">
                                <a type="button" class="btn btn-primary w-100 bntCerrarSesion">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    <script>
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('a.scroll-top').fadeIn('slow');
            } else {
                $('a.scroll-top').fadeOut('slow');
            }
        }); $('a.scroll-top').click(function (event) {
            event.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 600);
        });

        var pathname = window.location.pathname;
        $(document).ready(function() {
            $('.divIconLogout').show();
        });

        $(function () {
            $('[data-toggle="tooltipMenu"]').tooltip({
                html: true,
                "placement": "top",
                "container": "body",
            })
        });

        $('.logoutModal').on('click', function(){
            $("#modalCerrarSesion").modal('show');
        })

        $( ".bntCerrarSesion" ).click(function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
        $(function () {
            $('[data-toggle="tooltipLogout"]').tooltip({
                html: true,
                "placement": "bottom",
                "container": "body",
            });
        });
    </script>


    {{-- Incluir vista donde se encuentran las funciones de javascript que usara el sistema --}}
    @include('adminTemplate.layouts.assets.funciones_js')

    @stack('plugin-scripts')
    @yield('scripts')
    @stack('scripts')
    @endauth
</body>
</html>
