@extends ('adminTemplate.layouts.admin', ['title_template' => "Dentalife"])
@section('extracss')

@endsection
@section('contenidoHeader')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="page-pretitle">
                    Bienvenido
                </div>
                <h2 class="page-title">
                    {{ userFullName( auth()->user()->id )}}
                </h2>
            </div>
        </div>
    </div>
@endsection
@section('contenido')
    <div class="text-center">
        <h1>Dashboard</h1>
    </div>
@endsection
@section('scripts')

@endsection
