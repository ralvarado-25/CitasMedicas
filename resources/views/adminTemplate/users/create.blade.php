{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Control de citas"])

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
                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11h6m-3 -3v6" /></svg>
                        &nbsp;Registrar nuevo usuario
                    </h2>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    {!! Form::open(array('route' => 'users.store','method'=>'POST', 'onsubmit'=>'btnSubmit.disabled = true; return true;','id'=>'formCreateUsuarios')) !!}
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="username--label">* Nombre de usuario</label> &ensp;<small class="form-text text-primary font-weight-bold">** Con el cual accederá al sistema</small>
                <input class="form-control" placeholder="Nombre de usuario" id="name_usr" name="username">
                <span id="username-error" class="text-red"></span><br>
                <span id="validar" class="font-weight-bold" style="text-align:right"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="nro_doc--label">* Número de documento de identidad</label>&ensp;<small class="form-text text-primary font-weight-bold">** Este se almacenará como contraseña provisional</small>
                <input class="form-control" placeholder="CI, DNI, PASAPORTE" name="nro_doc">
                <span id="nro_doc-error" class="text-red"></span> <br>
            </div>
        </div>
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="name--label">* Nombre(s):</label>
                <input class="form-control" placeholder="Nombre(s)" name="name">
                <span id="name-error" class="text-red"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="ap_paterno--label">* Apellido Paterno:</label>
                <input class="form-control" placeholder="Apellido Paterno" name="ap_paterno">
                <span id="ap_paterno-error" class="text-red"></span>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="ap_materno--label">Apellido Materno:</label>
                <input class="form-control" placeholder="Apellido Materno" name="ap_materno">
                <span id="ap_materno-error" class="text-red"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="cargo--label">* Cargo:</label>
                <input class="form-control" placeholder="Cargo" name="cargo" value="{{old('cargo')}}">
                <span id="cargo-error" class="text-red"></span>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="email--label">* Email:</label>
                <input class="form-control" placeholder="Email" name="email" >
                <span id="email-error" class="text-red"></span>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label id="fecha_nac--label">Fecha de nacimiento</label>
                <div class="input-icon">
                    <input class="form-control datepicker" id="datepicker" type="text" name="fecha_nac" value="{{ date("d/m/Y") }}">
                    <span class="input-icon-addon icondiafecha">
                        <i class="fe fe-calendar"></i>
                    </span>
                </div>
                <span id="fecha_nac-error" class="text-red"></span>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box-header">
                    <label id="roles--label">* Asignar rol: </label> &nbsp;&nbsp;
                </div>
                <div class="form-group">
                    <select class="form-control form-select" name="roles">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <span id="roles-error" class="text-red"></span>
                </div>
            </div>
        </div>

        <div class="pull-right" id="registrar">
            <button type="submit" class="btn btn-primary" name="btnSubmit">Registrar</button>
        </div>
        <div class="pull-right" id="msgerror" style="display: none">
            <span class="help-block">
                <strong>El nombre de usuario debe ser único</strong>
            </span>
        </div>
    {!! Form::close() !!}

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#name_usr').keyup(function(){
            var query = $('#name_usr').val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('users.validar') }}",
                    method: "POST",
                    data: { query: query, _token: _token },
                    success: function (data) {
                        $('#validar').fadeIn();
                        $('#validar').html(data.msg);
                        setTimeout(function() {
                            $('#validar').fadeOut(1500);
                        },5000);
                        //$('#validar').fadeIn();
                        var sw=$('#sw').val();
                        if(sw==0){
                            $('#msgerror').hide();
                            $('#registrar').show();
                            $('#name_usr').removeClass('is-invalid').addClass('is-valid');
                        }else{
                            $('#name_usr').removeClass('is-valid').addClass('is-invalid');
                            $('#msgerror').show();
                            $('#registrar').hide();
                        }
                    }
                });
            }
        })
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true
    });
</script>

{{-- ===========================================================================================
                                VALIDACION DE CREATE USERS
=========================================================================================== --}}
    <script>
    var campos = [ 'username', 'nro_doc', 'name', 'ap_paterno', 'ap_materno', 'cargo', 'email', 'fecha_nac',  'roles'];
    ValidateAjax("formCreateUsuarios",campos,"btnSubmit","{{route('users.store')}}","POST","/usuarios");
</script>
@endsection
