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
                    @if (Gate::check('users.profile'))
                        <a class="dropdown-item" href="/perfil_usuario">
                            <i class="fe fe-user icon dropdown-item-icon"></i>
                            Perfil de usuario
                        </a>
                    @endif
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
                @if (Gate::check('citas.index'))
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
                @endif
                {{-- =================================================================================================================== --}}
                {{--                                                  USUARIOS                                                           --}}
                {{-- =================================================================================================================== --}}
                @if (Gate::check('users.index'))
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
                @endif
                {{-- =================================================================================================================== --}}
                {{--                                                    ROLES                                                            --}}
                {{-- =================================================================================================================== --}}
                @if (Gate::check('roles.index'))
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
                @endif
                {{-- =================================================================================================================== --}}
                {{--                                                DENTALIFE                                                            --}}
                {{-- =================================================================================================================== --}}
                @if (Gate::check('especialidades.index'))
                    <li class="nav-item {!!strstr($item,'.',true)=='4'?'active':'';!!}">
                        <a class="dropdown-item" href="/especialidades" >
                            <span class="nav-link-icon  d-lg-inline-block">
                                <img src="{{asset('icons/tooth.png')}}" width="20" height="20" style="{!!strstr($item,'.',true)=='4' ? 'filter: invert(57%) sepia(50%) saturate(468%) hue-rotate(134deg) brightness(101%) contrast(97%);' : 'filter: brightness(0) invert(1);'; !!}">
                            </span>
                            <span class="nav-link-title">
                                Especialidades &ensp;
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</aside>
