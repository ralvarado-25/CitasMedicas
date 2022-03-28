{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Roles del sistema"])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
    <style>
        table#tablaRoles th{
            font-size:12px;
        }
        table#tablaRoles td{
            font-size: 13px;
        }
        .izq{
            text-align: left !important;
        }
        .icon-tabler {
            width: 25px;
            height: 25px;
            stroke-width: 2;
            margin-bottom: 3px;
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
                        <img src="{{asset('icons/role.svg')}}" class="icon icon-tabler"> &nbsp;
                        Roles del sistema
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        @if (Gate::check('roles.create'))
            <div class="btn-list">
                <a href="/roles/create" >
                    <button class="btn btn btn-primary btn-pill">
                        <i class="fa fa-plus fa-md" ></i> &nbsp; Rol</span>
                    </button>
                </a>
            </div>
        @endif
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-vcenter table-center table-sm table-hover" id="tablaRoles">
                    <thead>
                        <th>NOMBRE</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ESTADO</th>
                        <th></th>
                    </thead>
                    <thead role="row">
                        <tr class="filters">
                            <td><input style="width: 100%;font-size:10px" id="roles0" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                            <td><input style="width: 100%;font-size:10px" id="roles1" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="descripcionb"/></td>
                            <td><input style="width: 100%;font-size:10px" id="roles2" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="estadob"/></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            @php
                                if(!Gate::check('roles.show'))
                                    $name = '<a href="/roles/show/'.code($role->id).'" target="_blank">'.$role->name.'</a>';
                                else
                                    $name = $role->name;
                            @endphp
                            <tr>
                                <td class="font-weight-bold">{!! $name !!}</td>
                                <td class="izq">{{ $role->description}}</td>
                                <td>
                                    @if ( $role->active==1 )
                                        <span class="badge badge-pill bg-green font-weight-bold p-2" >ACTIVO</span>
                                    @else
                                        <span class="badge badge-pill bg-red font-weight-bold p-2" >INACTIVO</span>
                                    @endif
                                </td>
                                <td>
                                    @if (Gate::check('roles.create'))
                                    <a href="{{ route('roles.show', code($role->id)) }}" title="Información">
                                        <svg class="icon text-muted iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                    </a> &nbsp;
                                    @endif
                                    @if (Gate::check('roles.edit'))
                                        <a href="{{ route('roles.edit', code($role->id)) }}" title="Editar">
                                            <svg class="icon text-muted iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                        </a> &nbsp;
                                    @endif
                                    @if (Gate::check('roles.changestatus'))
                                        @if ($role->active==1)
                                            <a title="Desactivar" data-toggle="modal" data-target="#modalState-{{$role->id}}" class="cursor-pointer">
                                                <svg class="icon text-danger iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                            </a>
                                        @else
                                            <a title="Activar" data-toggle="modal" data-target="#modalState-{{$role->id}}" class="cursor-pointer">
                                                <svg class="icon text-green iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- AQUI SE INCLUIRAN LOS MODALES PARA CREACION EDICION Y ELIMINACION --}}
    @foreach($roles as $role)
        @include('adminTemplate.roles.modalState')
    @endforeach


@endsection
@section('scripts')

<script>
    $(document).ready(function () {
        var table = $('#tablaRoles').DataTable({
            'mark'        : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : false,
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
