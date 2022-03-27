{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Editar usuario ".userFullName($user->id).""])

{{-- Dentro de esta seccion ira todo el codigo CSS --}}
@section('extracss')
    <style>
    </style>
    <link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/cropperjs/cropper.css')}}">
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
                        <i class="fa fa-user"></i> &nbsp;
                        Editar usuario {{userFullName($user->id)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    {!!Form::model($user,['route'=>['users.update', code($user->id)],'method'=>'POST','files'=>true,'id'=>'formEditUser'] ) !!}
    <div class="row">
        <div class="offset-lg-1 col-lg-10 offset-md-0 col-md-12 col-sm-12 col-xs-12 ">
            <div class="card animated zoomIn">
                <div class="card-header">
                    <h3 class="card-title pull-left text-primary ">
                        <b>DATOS PRINCIPALES</b>
                    </h3>
                </div>
                <div class="card-status-top bg-primary"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="offset-lg-1 col-lg-7">
                            <label id="username--label"> * Nombre de usuario</label>
                            <input id="nom_usr" class="form-control" type="text" value="{{$user->username}}" name="username" autocomplete="off" >
                            <span id="username-error" class="text-red"></span><br>
                            @if(\Auth::user()->role_id=='1')
                                <div class="my-2">
                                    <a id="showps" class="text-primary cursor-pointer"> <i class="fas fa-key" id="iconpass"></i> <b id="titlepass">Clic para cambiar contraseña</b></a>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="changeps" style="display: none">
                                    <div class="card">
                                        <div class="card-status-top bg-primary"></div>
                                        <div class="card-body">
                                            <div class="row form-group" id="password_first--label">
                                                <label class="col-md-4">* Contraseña nueva:</label>
                                                <div class="col-md-8">
                                                    <div class='input-group'>
                                                        <input id="password1" type='password' class="pass_quit form-control" name="password_first" style="border-right: 0px" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-eye-open" id="pass_first" title="Mostrar Contraseña"></span>
                                                        </span>
                                                    </div>
                                                    <span id="password_first-error" class="text-red"></span>
                                                </div>
                                            </div>
                                            <div class="row form-group" id="new_password--label">
                                                <label class="col-md-4">* Confirmar contraseña nueva:</label>
                                                <div class="col-md-8">
                                                    <div class='input-group'>
                                                        <input id="password2" type='password' class="pass_quit form-control" name="new_password" style="border-right: 0px" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-eye-open" id="pass_confirm" title="Mostrar Contraseña"></span>
                                                        </span>
                                                    </div>
                                                    <span id="new_password-error" class="text-red"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <b>La Contraseña nueva debe cumplir los siguientes requerimientos:</b><br>
                                            </div>
                                            <input type="text" name="auxpass" id="auxpass" value="0" hidden>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos 8 caracteres de longitud.<br>
                                                    <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos una letra mayúscula.
                                                </div>
                                                <div class="col-sm-6">
                                                    <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos una letra minúscula.<br>
                                                    <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos un número.
                                                </div>
                                                <div class="col-sm-12">
                                                    <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Los campos <b><i>"Contraseña Nueva"</i></b> y <b><i>"Confirmar Contraseña Nueva"</i></b> deben coincidir.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <label> AVATAR:</label>
                            <span class="form-help" data-toggle='popover' data-trigger='hover' data-content='<span style="font-size: 11px;" >Puede hacer clic sobra la imagen de avatar para cambiarla.<br><i>Antes de seguir asegúrese de guardar los datos que fueron modificados presionando <b>Actualizar datos</b></i> </span>' data-original-title='<span style="font-size: 12px; font-weight: bold ">Información</span>'>
                                ?
                            </span>
                            <img class="avatar-rounded cambiar_avatar" src="{{ imageRouteAvatar($user->avatar,1) }}" title="Presione para cambiar su imagen de avatar.<br><i>Antes de seguir asegúrese de guardar los datos que fueron modificados presionando <b>Actualizar datos</b></i>" style="width:185px; height:185px; margin-left: auto; margin-right: auto; margin-top: -20px; display: block; " title="Presione para cambiar su imagen de avatar" data-toggle="tooltip" />
                        </div>

                        <div class="col-lg-5 offset-lg-1 col-md-5 offset-md-1">
                            <div class="form-group">
                                <label id="name--label">* Nombre(s)</label>
                                <input class="form-control" value="{{$user->name}}" name="name" >
                                <span id="name-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5">
                            <div class="form-group">
                                <label id="ap_paterno--label">* Apellido Paterno</label>
                                <input class="form-control" value="{{$user->ap_paterno}}" name="ap_paterno">
                                <span id="ap_paterno-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 offset-lg-1 col-md-5 offset-md-1">
                            <div class="form-group">
                                <label id="ap_materno--label">Apellido Materno</label>
                                <input class="form-control" value="{{$user->ap_materno}}" name="ap_materno">
                                <span id="ap_materno-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5">
                            <div class="form-group">
                                <label id="cargo--label">* Cargo</label>
                                <input class="form-control" value="{{$user->cargo}}" name="cargo">
                                <span id="cargo-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 offset-lg-1 col-md-5 offset-md-1">
                            <div class="form-group">
                                <label id="email--label">* Email:</label>
                                <input class="form-control" type="text" value="{{$user->email}}" name="email">
                                <span id="email-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5">
                            <div class="form-group">
                                <label id="celular--label">Celular:</label><br>
                                <input class="form-control w-100" type="text" id="phonex" value="{{$user->celular}}" name="celular">
                                <span id="celular-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 offset-lg-1 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="fecha_nac--label">Fecha de nacimiento</label> <br>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i id="iconForm" class="far fa-calendar-alt"></i>
                                    </span>
                                    @php    $fechanac = isset($user->fecha_nacimiento) ? date("d/m/Y", strtotime($user->fecha_nacimiento)) : "";    @endphp
                                    <input class="form-control input-incon datepicker" type="text" name="fecha_nac" value="{{ $fechanac }}">
                                </div>
                                <span id="fecha_nac-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5">
                            <div class="form-group">
                                <label id="nro_doc--label">* Nº de Documento</label>
                                <input type="text" class="form-control pull-right" name="nro_doc" value="{{$user->nro_doc}}">
                            </div>
                            <span id="nro_doc-error" class="text-red"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 text-center">
            <div id="actualizar">
                <button class="btn btn-primary btn-pill btn-lg font-weight-bold" name="btnSubmitEdit">Actualizar datos</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="offset-lg-1 col-lg-10 offset-md-0 col-md-12 col-sm-12 col-xs-12 mt-4">
        <div class="card">
            <div class="card-status-top bg-primary"></div>
            <div class="card-header">
                <h3 class="card-title pull-left text-primary ">
                    <b>CAMBIAR ROL ASIGNADO </b>
                </h3>
            </div>

            <div class="row mx-4 mt-3 mb-3">
                <div class="col-lg-5 offset-lg-1 col-md-5 offset-md-1">
                    {!!Form::model($user,['route'=>['updaterol', $user->id],'method'=>'PUT','onsubmit'=>'btnASignar.disabled = true; return true;']) !!}
                        <div class="row">
                            <select class="form-control form-select" name="roles" id="rolSelect" style="width:100%">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" @if ($user->role_id == $role->id) selected @endif>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- modal de confirmacion --}}
                        <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalConfirmarAsign" data-backdrop="static">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-status bg-primary"></div>
                                    <div class="modal-body text-center py-4">
                                        <svg class="icon mb-2 text-primary icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                        <h3>¿Está seguro?</h3>
                                        <div class="text-muted">
                                            Todos los permisos asignados se reemplazarán por los definidos en el rol <b id="rolSpan"></b>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col">
                                                    <a class="btn w-100" data-dismiss="modal">
                                                        Cancelar
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary w-100" name="btnASignar">Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-lg-5 col-md-5 px-5">
                    <input class="btn btn-primary btn-pill w-100 font-weight-bold" type="button" value="Cambiar rol" id="btnAsignarRol">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal AVATAR --}}
    <input type="file" name="image" class="image" accept="image/*" id="inputImageAvatar" style="display:none">
    <div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalAvatar" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Cambiar avatar
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img id="imagAv" style="max-height: 600px">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
                        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
                        <input type="button" class="btn btn-primary pull-right" id="btnGuardarAvatar" value="Guardar imagen" >
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('/plugins/fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('/plugins/cropperjs/cropper.js')}}"></script>
<script>
    $('[data-toggle="tooltipUser"]').tooltip({
        html: true,
        "placement": "top",
        "container": "body",
    })

    $('#btnAsignarRol').on('click', function(){
        $("#modalConfirmarAsign").modal('show');
        var rolName = $('#rolSelect').find(':selected').html();
        $("#rolSpan").text(rolName);
    })

    // MOSTRAR U OCULTAR CAMBIO DE PASSWORD
    $( "#showps" ).click(function() {
        var aux = $("#auxpass").val();
        if(aux == 1){
            $("#auxpass").val(0);
            $("#changeps" ).fadeOut();
            $("#iconpass").removeClass('fa-times').addClass("fa-key");
            $("#titlepass").text("Clic para cambiar contraseña");
        }
        if(aux == 0){
            $("#auxpass").val(1);
            $("#changeps" ).fadeIn();
            $("#titlepass").text("Cancelar cambio de contraseña");
            $("#iconpass").removeClass('fa-key').addClass("fa-times");
        }
    });

    $(document).ready(function(){
        $("#auxpass").val(0);
        $(".btn-file").addClass('w-100');
    });

    $("#password1,#password2").keyup(function(){
        var ucase = new RegExp("[A-Z]+");
        var lcase = new RegExp("[a-z]+");
        var num = new RegExp("[0-9]+");

        // Condiciones
        var long8 = $("#password1").val().length >= 8;
        var mayus = ucase.test($("#password1").val());
        var minus = lcase.test($("#password1").val());
        var numero = num.test($("#password1").val());
        var iguales = ($("#password1").val() == $("#password2").val()) && $("#password1").val() != '' && $("#password2").val() != '';

        // 8 caracteres de longitud
        iconValidation(long8, $("#8char"));
        // Mayusculas
        iconValidation(mayus, $("#ucase"));
        // minusculas
        iconValidation(minus, $("#lcase"));
        // numeros
        iconValidation(numero, $("#num"));
        // iguales
        iconValidation(iguales, $("#pwmatch"));
    });

    $( "#pass_current" ).click(function() {
        if($(this).hasClass('glyphicon-eye-open')){
            $('#current-password').removeAttr('type');
            $('#pass_current').attr('title', 'Ocultar Contraseña');
            $('#pass_current').addClass('glyphicon-eye-close').removeClass('glyphicon-eye-open');
        }else{
            $('#current-password').attr('type','password');
            $('#pass_current').attr('title', 'Mostrar Contraseña');
            $('#pass_current').addClass('glyphicon-eye-open').removeClass('glyphicon-eye-close');
        }
    });

    $( "#pass_first" ).click(function() {
        if($(this).hasClass('glyphicon-eye-open')){
            $('#password1').removeAttr('type');
            $('#pass_first').attr('title', 'Ocultar Contraseña');
            $('#pass_first').addClass('glyphicon-eye-close').removeClass('glyphicon-eye-open');
        }else{
            $('#password1').attr('type','password');
            $('#pass_first').attr('title', 'Mostrar Contraseña');
            $('#pass_first').addClass('glyphicon-eye-open').removeClass('glyphicon-eye-close');
        }
    });

    $( "#pass_confirm" ).click(function() {
        if($(this).hasClass('glyphicon-eye-open')){
            $('#password2').removeAttr('type');
            $('#pass_confirm').attr('title', 'Ocultar Contraseña');
            $('#pass_confirm').addClass('glyphicon-eye-close').removeClass('glyphicon-eye-open');
        }else{
            $('#password2').attr('type','password');
            $('#pass_confirm').attr('title', 'Mostrar Contraseña');
            $('#pass_confirm').addClass('glyphicon-eye-open').removeClass('glyphicon-eye-close');
        }
    });
</script>

{{-- Recortar imagen avatar con CROPPER --}}
<script>
    $('.cambiar_avatar').click(function (event) {
        $("#inputImageAvatar").click();
    });
    var $modalavatar = $('#modalAvatar');
    var imageAvatar = document.getElementById('imagAv');
    var cropperAvatar;
    $("#inputImageAvatar").on("change", function (e) {
        var files = e.target.files;
        var done = function (url) {
            imageAvatar.src = url;
            $modalavatar.modal('show');
        };
        var reader;
        var file;
        var url;
        if ( files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modalavatar.on('shown.bs.modal', function () {
        cropperAvatar = new Cropper(imageAvatar, {
            aspectRatio: 700/700,
            viewMode: 0,
            crop(event) {
                console.log(event.detail.width);
                console.log(event.detail.height);
            },
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
        cropperAvatar.destroy();
        cropperAvatar = null;
    });

    $("#btnGuardarAvatar").click(function () {
        $(this).attr("disabled","disabled");
        canvas = cropperAvatar.getCroppedCanvas({
            width: 700,
            height: 700,
        });
        var btnEnviarEnc = $("#btnGuardarAvatar");
        var userid = "{{code($user->id)}}";
        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('users.avatar') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'image': base64data,
                        userid : userid
                    },
                    beforeSend: function(){
                        btnEnviarEnc.val("Guardando Imagen..."); // Para input de tipo button
                        btnEnviarEnc.attr("disabled","disabled");
                    },
                    complete:function(data){
                        btnEnviarEnc.val("Guardar Imagen");
                        btnEnviarEnc.attr("disabled","disabled");
                    },
                    success: function (data) {
                        $modalavatar.modal('hide');
                        btnEnviarEnc.removeAttr("disabled");
                        window.location.reload();
                    },
                    error: function(data){
                        toastr.error('Hubo un problema al actualizar los datos');
                    }

                });
            }
        });
    })
</script>

{{-- ===========================================================================================
                                            VALIDACION
=========================================================================================== --}}
<script>
    var campos = ['username','password_first','new_password','name','ap_paterno','ap_materno','cargo','email','celular','fecha_nac','nro_doc'];
    ValidateAjax("formEditUser",campos,"btnSubmitEdit","{{ route('users.update',code($user->id) )}}","POST");
</script>
@endsection
