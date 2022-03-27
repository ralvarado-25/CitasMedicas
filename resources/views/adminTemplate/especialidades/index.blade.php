{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Especialidades"])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')

    <link rel="stylesheet" href="{{asset('plugins/fileinput/css/fileinput.min.css')}}" media="all" type="text/css" />
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
                        <img class="icon" src="{{asset('icons/tooth.png')}}"> &nbsp;
                        Especialidades odontologicas
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <button type="button" class="btn btn-primary btn-pill" id="addEspecialidad" title="Nueva especialidad">
                <i class="fa fa-plus" ></i> &nbsp;
                <span class="d-none d-sm-inline-block">
                    Especialidad
                </span>
            </button>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="row">
        <div class="table-responsive">
            <table class="table table-vcenter table-center table-sm table-hover" id="tablaEspecialidad">
                <thead>
                    <tr>
                        <th width="10%">CÓDIGO</th>
                        <th width="10%">REGISTRADO POR</th>
                        <th width="10%">NOMBRE</th>
                        <th width="20%">DESCRIPCIÓN</th>
                        <th width="10%">DURACIÓN APROXIMADA</th>
                        <th width="10%">ESTADO</th>
                        <th width="10%">OPERACIONES</th>
                    </tr>
                </thead>

                <thead role="row">
                    <tr class="filters">
                        <td><input style="width: 100%;font-size:10px" id="especialidad0" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="codigob"/></td>
                        <td><input style="width: 100%;font-size:10px" id="especialidad1" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="registradob"/></td>
                        <td><input style="width: 100%;font-size:10px" id="especialidad2" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                        <td><input style="width: 100%;font-size:10px" id="especialidad3" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="descripcionb"/></td>
                        <td><input style="width: 100%;font-size:10px" id="especialidad4" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="duracionb"/></td>
                        <td><input style="width: 100%;font-size:10px" id="especialidad5" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="estadob"/></td>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                    @foreach($especialidades as $esp)
                        <tr>
                            <td class="font-weight-bold">{!!$esp->getCod()!!}</td>
                            <td>{{userFullName($esp->user_id)}}</td>
                            <td>{{$esp->nombre}}</td>
                            <td class="just">{!! $esp->descripcion !!}</td>
                            <td>{{$esp->duracion}} Horas</td>
                            <td>{!!$esp->getEstado()!!}</td>
                            <td>
                                <a rel="modalEdit" style="cursor:pointer" href="/especialidad/editmodal/{{code($esp->id)}}" title="Editar" data-toggle="tooltip">
                                    <svg class="icon text-blue iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                </a>

                                @if ($esp->active==1)
                                    <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($esp->id)}}" title="Desactivar" data-toggle="tooltip">
                                        <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                    </a>
                                @else
                                    <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($esp->id)}}" title="Activar" data-toggle="tooltip">
                                        <svg class="icon text-green iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                    </a>
                                @endif
                                <a rel="modalEliminar" style="cursor:pointer" href="/users/modalDelete/{{code($esp->id)}}" data-toggle="tooltip" data-placement="top" title="Eliminar" data-toggle="tooltip">
                                    <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('adminTemplate.especialidades.modalCreate')

    <div class="modal modalPrimary modal-info fade modal-slide-in-right" aria-hidden="true" role="dialog" id="modalShow" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>

    {{-- Modal Editar --}}
    <div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalEdit" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar especialidad</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="{{asset('/plugins/fileinput/js/fileinput.min.js')}}"></script>
<script>
        modalAjax("modalShow","modalShow","modal-content");
        modalAjax("modalEdit","modalEdit","modal-body");
        var campos = ['nombre','descripcion'];
        $( "#addEspecialidad" ).click(function() {
            $('#modalCrearEspecialidad').modal('show');
            $.each(campos, function( indice, valor ) {
                $("#"+valor+"-error").html( "" );
                $("[name="+valor+"]").removeClass('is-invalid').removeClass('is-valid');
                $("select[name="+valor+"]").removeClass('is-invalid-select').removeClass('is-valid-select');
                $("#formCreateAreas #"+valor+"-sel2 .select2-selection").removeClass('is-invalid-select').removeClass('is-valid-select');
            });
        });

        $(document).ready(function () {
            var table = $('#tablaEspecialidad').DataTable({
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
