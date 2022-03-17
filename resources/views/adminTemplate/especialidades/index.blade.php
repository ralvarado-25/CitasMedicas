{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Especialidades"])

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
                        <i class="fa fa-globe-americas"></i> &nbsp;
                        Registro de especialidades
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir nuevo registro --}}
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            {{-- los botones iran aqui --}}
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    <div class="row">
        Contenido aca
    </div>

    {{-- AQUI SE INCLUIRAN LOS MODALES PARA CREACION EDICION Y ELIMINACION --}}
    @include('adminTemplate.especialidades.modalCreate')

    @include('adminTemplate.especialidades.modalEdit')
    @include('adminTemplate.especialidades.modalDelete')

@endsection
@section('scripts')

<script>

</script>

@endsection
