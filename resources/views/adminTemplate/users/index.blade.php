{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Usuarios"])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
<style>
    .info-box {
        min-height: 60px;
    }
    .info-box-icon {
        height: 60px; line-height: 50px;
    }
    .info-box-content {
        padding-top: 5px; padding-bottom: 5px;
    }
    @media  (max-width: 1000px){
        #botonesexport{ text-align: center }
    }
    .icon-tabler {
        width: 25px;
        height: 25px;
        stroke-width: 1.25;
        margin-bottom:5px;
    }
    table#tablaUser th{
        font-size:12px;
    }
    table#tablaUser td{
        font-size: 13px;
    }
    .avatar-status {
        position: absolute;
        right: -2px;
        bottom: -2px;
        width: 1rem;
        height: 1rem;
        border: 2px solid #fff;
        border-radius: 50%;
    }
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
                        <svg class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                        </svg>&nbsp;
                        Usuarios
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="/users/create" title="Nuevo usuario">
                <button class="btn btn btn-primary btn-pill" >
                    <i class="fa fa-plus fa-md" ></i> &nbsp;
                    <span class="d-none d-sm-inline-block">
                        Usuario
                    </span>
                </button>
            </a>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="row">
        <!-- INDICADORES DE USUARIO -->
        <div class="row justify-content-lg-center mb-2">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar avatar-md text-white" style="background: #2fb344 !important">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11l2 2l4 -4" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-bold">{{$usersactive}}</div>
                                <div class="text-muted">Usuarios activos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar avatar-md text-white" style="background: #F7A600 !important">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.274 10.291a4 4 0 1 0 -5.554 -5.58m-.548 3.453a4.01 4.01 0 0 0 2.62 2.65" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 1.147 .167m2.685 2.681a4 4 0 0 1 .168 1.152v2" /><line x1="3" y1="3" x2="21" y2="21" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-bold">{{$usersinactive}}</div>
                                <div class="text-muted">Usuarios inactivos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar avatar-md bg-red text-white" style="background: #d63939 !important">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M17 9l4 4m0 -4l-4 4" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-bold">{{$usersdelete}}</div>
                                <div class="text-muted">Usuarios eliminados</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter table-center table-sm table-hover" id="tablaUser">
            <thead>
                <tr>
                    <th width="5%" style="color:transparent !important"></th>
                    <th class="hidden"></th>
                    <th width="20%">NOMBRE(S)</th>
                    <th width="20%">E-MAIL</th>
                    <th width="10%">ESTADO</th>
                    <th width="20%">CARGO</th>
                    <th width="10%">OPERACIONES</th>
                </tr>
            </thead>

            <thead role="row">
                <tr class="filters">
                    <td></td>
                    <td class="hidden"></td>
                    <td><input style="width: 100%;font-size:10px" id="user0" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                    <td><input style="width: 100%;font-size:10px" id="user1" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="emailb"/></td>
                    <td><input style="width: 100%;font-size:10px" id="user2" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="estadob"/></td>
                    <td><input style="width: 100%;font-size:10px" id="user3" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="cargob"/></td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                @foreach($usersa as $user)
                    <tr>
                        <td>
                            <center>
                            <span class="avatar avatar-sm avatar-rounded" style="background-image: url({{ imageRouteAvatar($user->avatar,1) }}); ">
                                <span class="@if( $user->id == userId() ) avatar-status bg-success @endif"></span>
                            </span>
                            </center>
                        </td>
                        <td class="hidden">{{ code($user->id)}}</td>

                        <td style="text-align: left !important"> {!! $user->getName() !!} </td>
                        <td style="text-align: left !important">{{ $user->email }}</td>
                        <td class="text-center">
                            @if ( $user->active==1 )
                                <span class="badge badge-pill bg-green">ACTIVO</span>
                            @else
                                <span class="badge badge-pill bg-red">INACTIVO</span>
                            @endif
                        </td>
                        <td style="text-align: left !important">{{ $user->cargo }}</td>
                        <td>
                            <a href="/users/{{code($user->id)}}/edit" title="Editar" data-toggle="tooltip">
                                <svg class="icon text-blue iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                            </a>
                            <a href="/users_privilegios/{{code($user->id)}}/edit" title="Permisos" data-toggle="tooltip">
                                <svg class="icon text-orange iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                            </a>
                            @if($user->id != userId())
                                @if ($user->active==1)
                                    <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($user->id)}}" title="Desactivar" data-toggle="tooltip">
                                        <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                    </a>
                                @else
                                    <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($user->id)}}" title="Activar" data-toggle="tooltip">
                                        <svg class="icon text-green iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                    </a><br>
                                @endif
                                <a rel="modalEliminar" style="cursor:pointer" href="/users/modalDelete/{{code($user->id)}}" data-toggle="tooltip" data-placement="top" title="Eliminar" data-toggle="tooltip">
                                    <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- AQUI SE INCLUIRAN LOS MODALES PARA CREACION EDICION Y ELIMINACION --}}
    @include('adminTemplate.citas.modalCreate')

    @include('adminTemplate.citas.modalEdit')
    @include('adminTemplate.citas.modalDelete')

@endsection
@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#tablaUser').DataTable({
            'mark'        : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "order": [[ 0, "desc" ]],
            "pageLength": 25,
            "columnDefs": [ {
                "orderable": false, //5
                    "targets": ["_all"] ,
            } ],

            "drawCallback": function () {
                $('[data-toggle="popoverOper"]').popover({
                    html: true,
                    "trigger" : "focus",
                    "placement": "left",
                    "container": "body",
                    delay: {
                        "hide": 200
                    }
                });

                modalAjax("modalEliminar","modalEliminar","modal-content");
                modalAjax("modalCambioEstado","modalCambioEstado","modal-content");
                $('.inputSearchDT').on('paste', function(e) {
                    var valor = e.originalEvent.clipboardData.getData('Text');
                    var id = $(this).attr('id');
                    if ( noPegar(valor,id,'top') == 1) e.preventDefault();
                });
                $('.inputSearchDT').on('drop', function(e) {
                    event.preventDefault();
                    event.stopPropagation();
                    var id = $(this).attr('id');
                    $('#'+id).attr('data-toggle','popover');
                    $('#'+id).attr('data-trigger','manual');
                    $('#'+id).attr('data-content','<span class="text-red font-weight-bold"><center><i class="fa fa-ban"></i> La acción no se puede realizar.<br>Por favor escríba el texto</center></span>');
                    $('#'+id).attr('data-placement','top');
                    $('#'+id).attr('data-html','true');
                    $('#'+id).attr('data-container','body');
                    $('#'+id).popover('show');
                    setTimeout(function(){
                        $('#'+id).popover('hide');
                        $('#'+id).removeAttr('data-toggle');
                        $('#'+id).removeAttr('data-trigger');
                    }, 2000)
                });
            }
        });

        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', $('.filters td')[colIdx] ).on( 'keyup', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
            } );
        });
    });
</script>

@endsection
