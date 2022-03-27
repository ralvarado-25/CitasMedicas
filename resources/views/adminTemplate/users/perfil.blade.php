{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Editar perfil"])

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
                        Perfil: {{userFullName(auth()->user()->id)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('contenido')
    {{-- EL CONTENIDO GRAL DE LA VISTA IRA AQUI --}}
    {!!Form::model(auth()->user(),['route'=>['updateprofile', auth()->user()->id],'method'=>'POST','files'=>true,'id'=>'formProfile' ]) !!}
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="container d-flex h-100">
                <div class="row justify-content-center align-self-center">
                    <img id="imgAvatar" class="avatar-rounded cambiar_avatar" src="{{ imageRouteAvatar(auth()->user()->avatar,0) }}" title="Presione para cambiar la imagen de avatar<br><i>Antes de seguir asegúrese de guardar los datos que fueron modificados presionando <b>Modificar perfil</b></i>" data-toggle="tooltipUser"/>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-status-top bg-primary"></div>
                <div class="card-header">
                    <h3 class="card-title pull-left text-primary ">
                        <b>DATOS PERSONALES </b>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Nombre de usuario:</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                <i class="fe fe-user"></i>
                                </span>
                                <input type="text" class="form-control" disabled value="{{auth()->user()->username}}">
                            </div>
                        </div>
                    </div>
                    {{-- Cambiar contraseña --}}
                    <div style="margin-bottom:15px">
                        <a href='#' id="showps" class="text-primary"> <i class="fas fa-key" id="iconpass"></i> <b id="titlepass">Clic para cambiar contraseña</b></a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2" id="changeps" style="display: none">
                        <div class="card">
                            <div class="card-status-top bg-primary"></div>
                            <div class="card-body">
                                <div class="row form-group" id="current_password--label">
                                    <label class="col-md-4">* Contraseña Actual: </label>
                                    <div class="col-md-8">
                                        <div class='input-group'>
                                            <input id="current_password" type='password' class="pass_quit form-control" name="current_password" style="border-right: 0px" placeholder="Ingrese su contraseña actual"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-eye-open" id="pass_current" title="Mostrar Contraseña"></span>
                                            </span>
                                        </div>
                                        <span id="current_password-error" class="text-red"></span>
                                    </div>
                                </div>
                                <div class="row form-group" id="password_first--label">
                                    <label class="col-md-4">* Contraseña Nueva:</label>
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
                                    <label class="col-md-4">* Confirmar Contraseña Nueva:</label>
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

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="name--label">* Nombre(s): </label>
                                <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
                                <span id="name-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="ap_paterno--label">* Apellido paterno: </label>
                                <input type="text" class="form-control" name="ap_paterno" value="{{auth()->user()->ap_paterno}}">
                                <span id="ap_paterno-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="ap_materno--label">Apellido materno: </label>
                                <input type="text" class="form-control" name="ap_materno" value="{{auth()->user()->ap_materno}}">
                                <span id="ap_materno-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="fechanac--label">Fecha de nacimiento:</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                    <i class="fas fa-calendar-alt fa-sm"></i>
                                    </span>
                                    @php
                                        $fecha = isset(auth()->user()->fecha_nacimiento) ? date("d/m/Y",strtotime(auth()->user()->fecha_nacimiento)) : "";
                                    @endphp
                                    <input type="text" class="form-control datepicker" style="height: 35px" value="{{ $fecha }}" name="fechanac" placeholder="dd/mm/YYYY">
                                </div>
                                <span id="fechanac-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="email--label">* Email:</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                    <i class="fas fa-at fa-sm"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{auth()->user()->email}}" name="email">
                                </div>
                                <span id="email-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="cargo--label">Cargo:</label>
                                <input type="text" class="form-control" value="{{auth()->user()->cargo}}" name="cargo">
                                <span id="cargo-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="nrodoc--label">* Documento de identidad: </label>
                                <input type="text" class="form-control" name="nrodoc" value="{{auth()->user()->nro_doc}}" placeholder="Número de documento de identidad">
                                <span id="nrodoc-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label id="celular--label">Celular: </label><br>
                                <input type="text" id="phonex" class="form-control" name="celular" value="{{auth()->user()->celular}}">
                                <span id="celular-error" class="text-red"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" class="btn btn-primary text-center btn-pill btn-lg" name="btnSubmit">Modificar perfil</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

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
        var userid = "{{code(auth()->user()->id)}}";
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

<script>
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
            $('#current_password').removeAttr('type');
            $('#pass_current').attr('title', 'Ocultar Contraseña');
            $('#pass_current').addClass('glyphicon-eye-close').removeClass('glyphicon-eye-open');
        }else{
            $('#current_password').attr('type','password');
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

<script>
     // Validar forms por AJAX
    var camposprofile = ['current_password','password_first','new_password','name','ap_paterno','ap_materno','fechanac','email','cargo','nrodoc','celular',];
    ValidateAjax("formProfile",camposprofile,"btnSubmit","{{route('updateprofile',code(userId()))}}","POST");
</script>

@endsection
