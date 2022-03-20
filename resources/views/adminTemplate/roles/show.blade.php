{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Datos de rol ".$role->name.""])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')

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
                        <i class="fa fa-globe-americas"></i> &nbsp;
                        Rol&nbsp; <b>{{$role->name}}</b> &nbsp;&nbsp;
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="/roles" class="btn btn-outline-secondary" title="Ver todos los roles">
                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" />
                </svg>
                <span class="d-none d-sm-inline-block">
                    Ver roles
                </span>
            </a>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="col-lg-12">
        <div class="row" style="margin-bottom:20px" data-step="2" data-intro="Usando estos botones puede editar, desactivar y eliminar el Rol <b>{{$role->name}}</b>">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-center">
                    <a href="/roles/{{code($role->id)}}/edit" class="btn btn-ghost-primary border border-primary">
                        <i class="fa fa-edit"></i>&nbsp; Modificar rol
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-center">
                    {!! Form::open(['route'=>['roles.changestatus', code($role->id)], 'method'=>'GET']) !!}
                        @if ($role->active==0)
                            <button type="button" class="btn btn-ghost-info font-weight-bold border border-info" id="btnActivar">
                                <i class="fa fa-plug"></i>&nbsp; Activar rol
                            </button>
                        @else
                            <button type="button" class="btn btn-ghost-orange border border-orange font-weight-bold" id="btnActivar">
                                <i class="fa fa-plug"></i>&nbsp; Desactivar rol
                            </button>
                        @endif

                        {{-- modal de estado --}}
                        <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" id="modalRolEstado" data-backdrop="static">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-status @if($role->active==0) bg-info @else bg-red @endif"></div>
                                    <div class="modal-body text-center py-4">
                                        <svg class="icon @if($role->active==0) text-info @else text-red @endif icon-lg" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 6a7.75 7.75 0 1 0 10 0" />
                                            <line x1="12" y1="4" x2="12" y2="12" />
                                        </svg>
                                        <h3>¿Está seguro?</h3>
                                        <div class="text-muted">
                                            ¿Está seguro de cambiar a estado @if($role->active==0) ACTIVO @else INACTIVO @endif al rol <b>{{$role->name}}</b>?
                                        </div>
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
                                                    <button type="submit" class="btn @if($role->active==0) btn-info @else btn-red @endif w-100" name="btnASignar">Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        {{--//========================================================================================
        *                               Lista de permisos del rol                                   *
        //========================================================================================--}}

        <div class="table-responsive">
            <table class="table table-vcenter table-lg table-hover">
                <thead>
                    <tr>
                        <th style="width: 50%; text-align: center;font-size:14px;">ROL</th>
                        <th style="width: 50%; text-align: center;font-size:14px;">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%; text-align: center;">{{$role->name}} </td>
                        <td style="width: 50%; text-align: center;">
                            @if ($role->active == 1)
                                <span class="badge badge-pill bg-green">ACTIVO </span>
                            @else
                                <span class="badge badge-pill bg-red">INACTIVO </span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="font-size:14px">PERMISOS ASIGNADOS</th>
                    </tr>
                </thead>
                <tbody>
                    @php    $aux = "";  @endphp
                    @if (count($permissions)>0)
                        @foreach ($permissions as $permission)
                            @if ($permission->parent_id != $aux)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 font-weight-bold text-yellowdark">
                                                {{ permisoName($permission->parent_id) }}
                                            </div>
                                            @foreach ($permissions->where('parent_id',$permission->parent_id) as $permChild)
                                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 ">
                                                    <svg class="icon" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <circle cx="12" cy="12" r="4" />
                                                    </svg>
                                                    {!! $permChild->description !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @php    $aux = $permission->parent_id;  @endphp
                        @endforeach
                    @else
                        <td class="text-center"> No se encontrarón permisos asociados</td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('scripts')

@endsection
