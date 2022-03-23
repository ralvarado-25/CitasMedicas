{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Usuario: ".userFullName($user->id)])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
    <style>
    </style>

@endsection
{{-- Cabecera de la pagina --}}
@section('contenidoHeader')
    <div class="col-auto">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="page-pretitle">
                        Dentalife
                    </div>
                    <h2 class="page-title">
                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11l2 2l4 -4" /></svg>
                        &nbsp;Usuario: &nbsp;&nbsp;{{userFullName($user->id)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="/roles" class="btn btn-outline-secondary">
                <b><svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                Ver roles</b>
            </a>
            <a href="/usuarios" class="btn btn-outline-secondary">
                <b><svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                Ver usuarios</b>
            </a>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="col-lg-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-sm-12">
                    <img class="img-rounded" style="max-width: 40%; margin-left: auto; margin-right: auto; display: block;" src="{{ imageRouteAvatar($user->avatar,0) }}">
                </div>
                <div class=" col-md-7 col-lg-7 col-sm-12">
                    <table class="table table-lg table-responsive" >
                        <tr>
                            <td class="font-weight-bold">Nombre</td>
                            <td>{{userFullName($user->id)}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nombre de usuario</td>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">E-mail</td>
                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Cargo</td>
                            <td>{{$user->cargo}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Celular</td>
                            <td>{{$user->celular}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Rol</td>
                            <td>
                                @if (isset($rol->name))
                                    <label class="badge badge-info">
                                        {{ isset($rol->name) ? $rol->name : "" }}
                                    </label>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Estado:</td>
                            <td>@if ( $user->active==1 )
                                <span class="badge badge-pill bg-green p-2">ACTIVO</span>
                                @else
                                <span class="badge badge-pill bg-red p-2">INACTIVO</span>
                                @endif</td>
                            <td>
                        </tr>
                    </table>
                </div>

            </div>

            {{--//========================================================================================
            *                                    Fin de la información                                  *
            //========================================================================================--}}
            <div class="row justify-content-md-center" style="margin-top:20px">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <a href="/usuarios/{{ code($user->id)}}/edit">
                        <button class="btn btn-ghost-primary btn-lg border border-primary" >
                            <i class="fas fa-edit fa-md"></i> &nbsp;&nbsp;
                            <span > Editar </span>
                        </button>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <a href="/usuarios_privilegios/{{code($user->id)}}/edit" >
                        <button class="btn btn-ghost-orange btn-lg border border-orange" >
                            <i class="fas fa-lock fa-md"></i> &nbsp;&nbsp;
                            <span > Privilegios </span>
                        </button>
                    </a>
                </div>
                @if($user->id != userId())
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <a rel="modalCambioEstado" href="/usuarios/modalCambEstado/{{code($user->id)}}" data-step="5" data-intro="Presionando este botón abrirá una nueva ventana de confirmación para Activar o Desactivar el usuario.">
                            @if ($user->active==1)
                                <button class="btn btn-ghost-yellow btn-lg border border-yellow">
                                    <i class="fas fa-plug fa-md"></i> &nbsp;&nbsp;
                                    <span> Desactivar </span>
                                </button>
                            @else
                                <button class="btn btn-ghost-info btn-lg border border-info">
                                    <i class="fas fa-plug fa-md"></i> &nbsp;&nbsp;
                                    <span> Activar </span>
                                </button>
                            @endif
                        </a>
                    </div>
                @endif
                @if($user->id != userId())
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <a rel="modalEliminar" href="/usuarios/modalDelete/{{code($user->id)}}" data-step="6" data-intro="Presionando este botón abrirá una nueva ventana de confirmación para Eliminar el usuario.">
                            <button class="btn btn-ghost-danger btn-lg border border-danger">
                                <i class="fa fa-trash-alt fa-md"></i> &nbsp;&nbsp;
                                <span> Eliminar </span>
                            </button>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- AQUI SE INCLUIRAN LOS MODALES PARA CREACION EDICION Y ELIMINACION --}}
    @include('adminTemplate.citas.modalCreate')

    @include('adminTemplate.citas.modalEdit')
    @include('adminTemplate.citas.modalDelete')

@endsection
@section('scripts')
@endsection
