{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Crear rol"])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
<style>
    .buttontodo:hover{
        box-shadow: 2px 2px 2px 1px rgba(32, 107, 196, 0.2);
    }
    .buttontodoquitar:hover{
        box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
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
                        Crear nuevo rol
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
    <div class="col-lg-12" id="permissions--label">
        {!!Form::open(['route'=>'roles.store', 'method'=>'POST', 'id'=>'formCreateRoles', 'onsubmit'=>'btnSubmit.disabled = true; return true;' ]) !!}
            <div class="row" data-step="1" data-intro="Introduzca un nombre para el nuevo Rol a crear en el campo <b>Nombre del Rol</b> y una pequeña descripción sobre este rol.">
                <div class="form-group col-md-4">
                    <label id="name--label">* Nombre del rol</label>
                    <input type="text" name="name" class="form-control">
                    <span class="text-red" id="name-error"></span>
                </div>
                <div class="form-group col-md-8">
                    <label id="description--label">* Descripción del rol</label>
                    <input type="text" name="description" class="form-control">
                    <span class="text-red" id="description-error"></span>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center font-weight-bold m-2" >
                <span class="text-red" style="font-size:18px" id="permissions-error"></span>
            </div>
            <ul class="nav nav-tabs font-weight-bold" data-toggle="tabs" >
                <li class="nav-item ">
                    <a href="#roles_usuarios" data-toggle="tab" class="nav-link active">
                        <i class="fa fa-users"></i> &ensp;
                        Roles y usuarios
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#control_citas" data-toggle="tab" class="nav-link">
                        <i class="fas fa-clipboard-list icon"></i> &ensp;
                        Control de citas
                    </a>
                </li>
                <li>
                    <a href="#especialidades" data-toggle="tab" class="nav-link">
                        <img src="{{asset('icons/tooth.png')}}" width="20" height="20" style="filter: invert(43%) sepia(16%) saturate(277%) hue-rotate(176deg) brightness(95%) contrast(88%);"> &ensp;
                        Especialidades
                    </a>
                </li>
            </ul>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="roles_usuarios">
                        <div class="container-fluid">
                            @foreach ($permissions_ as $perm)
                                {{-- @if($perm->id=='1' || $perm->id=='2' || $perm->id=='3') --}}
                                @if($perm->id=='2' || $perm->id=='3')
                                    @include('adminTemplate.roles.form')
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane" id="control_citas">
                        <div class="container-fluid">
                            @foreach ($permissions_ as $perm)
                                @if($perm->id=='4')
                                    @include('adminTemplate.roles.form')
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane" id="especialidades">
                        <div class="container-fluid">
                            @foreach ($permissions_ as $perm)
                                @if($perm->id=='5')
                                    @include('adminTemplate.roles.form')
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit" name="btnSubmit">Crear rol</button>
            </div>
        {!!Form::close()!!}
    </div>

@endsection
@section('scripts')
    <script>
        $('.buttontodoquitar').click(function () {
            var pk = $(this).attr('data-pk');
            $(".checkb"+pk+"").prop('checked', false);
        });

        $('.buttontodo').click(function () {
            var pk = $(this).attr('data-pk');
            $(".checkb"+pk+"").prop('checked', true);
        });

        $('.buttontodoparentquitar').click(function () {
            var pk = $(this).attr('data-pk');
            $(".checkparent"+pk+"").prop('checked', false);
        });

        $('.buttontodoparent').click(function () {
            var pk= $(this).attr('data-pk');
            $(".checkparent"+pk+"").prop('checked', true);
        });
    </script>

    {{-- ===========================================================================================
                                                VALIDACION
    =========================================================================================== --}}
    <script>
        var campos = ['name','description','permissions'];
        ValidateAjax("formCreateRoles",campos,"btnSubmit","{{route('roles.store')}}","POST","/roles");
    </script>

@endsection
