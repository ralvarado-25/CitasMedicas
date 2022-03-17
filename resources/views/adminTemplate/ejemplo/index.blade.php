{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Vista de ejemplo"])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
    <style>

    table#tablePrograms th{
        vertical-align:middle;
        font-size:12px;
        text-align: center;
    }
    table#tablePrograms td{
        vertical-align:middle;
        text-align: center;
        line-height:14px;
        font-size: 13px;
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
                        <i class="fa fa-globe-americas"></i> &nbsp;
                        Ejemplo
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Boton para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a type="button" class="btn btn-yellow btn-pill" href="/enviarMail" target="_blank">
                <span class="d-none d-sm-inline-block">
                    Ejemplo envio de mails
                </span>
            </a>

            <a type="button" class="btn btn-danger btn-pill" href="/ejemplo/pdf" target="_blank">
                <i class="fas fa-file-pdf fa-lg" ></i> &nbsp;
                <span class="d-none d-sm-inline-block">
                    Reporte en PDF
                </span>
            </a>
            <button type="button" class="btn btn-primary btn-pill" title="Nuevo registro" data-toggle="modal" data-target="#modalCreate">
                <i class="fa fa-plus" ></i> &nbsp;
                <span class="d-none d-sm-inline-block">
                    Registro
                </span>
            </button>
        </div>
    </div>
@endsection
@section('contenido')
    <div class="row">
        <div class="table-responsive">
            <table class="table  table-sm table-hover" id="tablePrograms">
                <thead>
                    <tr>
                        <th class="text-center" width="10%">Código</th>
                        <th class="text-center" width="20%">Usuario</th>
                        <th class="text-center" width="10%">Fecha inicial</th>
                        <th class="text-center" width="10%">Fecha final</th>
                        <th class="text-center" width="25%" style="text-align:center !important">Descripción</th>
                        <th class="text-center" width="10%">Estado</th>
                        <th class="text-center" width="10%">Operaciones</th>
                    </tr>
                </thead>
                <thead role="row">
                    <tr class="filters">
                        <td><input style="width: 100%;font-size:10px" id="ejemplo0" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="siglab"/></td>
                        <td><input style="width: 100%;font-size:10px" id="ejemplo1" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="categoriab"/></td>
                        <td><input style="width: 100%;font-size:10px" id="ejemplo2" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="fechainib"/></td>
                        <td><input style="width: 100%;font-size:10px" id="ejemplo3" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="fechafinb"/></td>
                        <td><input style="width: 100%;font-size:10px" id="ejemplo4" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="descripcionb"/></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listaEjemplos as $ejemplo)
                        <tr>
                            <td> {{$ejemplo->cod}} </td>
                            <td> {{$ejemplo->usuario->name}} {{$ejemplo->usuario->ap_paterno}} </td>
                            <td> {{fechaConv($ejemplo->start_date)}} </td>
                            <td> {{fechaConv($ejemplo->end_date)}} </td>
                            <td class="text-justify"> {{$ejemplo->description  }} </td>
                            <td> {!! $ejemplo->getEstado() !!} </td>
                            <td>
                                {{-- Boton para editar --}}
                                <button class="btn" title="Editar {{$ejemplo->cod}}" data-toggle="modal" data-target="#modalEdit-{{$ejemplo->id}}">
                                    <i class="fa fa-edit text-primary"></i>
                                </button>
                                {{-- Boton para eliminar --}}
                                <button class="btn" title="Eliminar {{$ejemplo->cod}}" data-toggle="modal" data-target="#modalDelete-{{$ejemplo->id}}">
                                    <i class="fa fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('adminTemplate.ejemplo.modalCreate')

    @foreach ($listaEjemplos as $ejemplo)
        @include('adminTemplate.ejemplo.modalEdit')
        @include('adminTemplate.ejemplo.modalDelete')
    @endforeach

@endsection
@section('scripts')

<script>
    $(document).ready(function () {
        var table = $('#tablePrograms').DataTable({
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
