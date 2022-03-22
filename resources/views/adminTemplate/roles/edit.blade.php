{{-- Obtener plantilla de la vista desde el archivo admin --}}
@extends ('adminTemplate.layouts.admin', ['title_template' => "Datos de rol ".$role->name.""])

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
                        Editar rol&nbsp; <b>{{$role->name}}</b> &nbsp;&nbsp;
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
    @php
        $contid = isset($_GET['contid']) ? $_GET['contid'] : "";
    @endphp
    <div class="col-lg-12" id="permissions--label">
        @if (Session::has('messageRol'))
            <div class="alert alert-important alert-dismissible animated pulse infinite" role="alert" style="background-color: #f7a600 !important">
                <div class="d-flex">
                    <div>
                        <svg class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                    </div>
                    <div class="font-weight-bold" style="font-size:16px">
                        &nbsp; {{ Session::get('messageRol') }}
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close" ></a>
            </div>
        @endif
        {!!Form::model($role, ['route'=>['roles.update', code($role->id)],'method'=>'POST', 'id'=>'formEditRoles']) !!}
            <div class="row">
                <div class="form-group col-md-4">
                    <label id="name--label">* Nombre del rol</label>
                    <input type="text" name="name" class="form-control" value="{{$role->name}}" placeholder="Nombre del rol">
                    <span class="text-red" id="name-error"></span>
                </div>
                <div class="form-group col-md-8">
                    <label id="description--label">* Descripción del rol</label>
                    <input type="text" name="description" class="form-control" value="{{$role->description}}" placeholder="Descripción del rol">
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

            <input type="text" id="tabinput" name="tabinput" value="{{  $contid }}" hidden>
            <div class="box-footer">
                <div class="pull-right">
                    <div class="mb-3">
                        <label class="text-primarydark"> Por favor escriba su contraseña para confirmar los cambios</label>
                        <div class='input-group'>
                            <input id="password1" type='password' class="pass_quit form-control" name="rolBorrar" style="border-right: 0px" placeholder="Escriba su contraseña" autocomplete="off" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-eye-open" id="pass_first" title="Mostrar Contraseña"></span>
                            </span>
                        </div>
                        <span class="text-red" id="rolBorrar-error"></span>
                    </div>
                    <button class="btn btn-primary pull-right" type="submit" name="btnSubmit">Actualizar rol</button>
                </div>

            </div>
        {!!Form::close()!!}
    </div>

@endsection
@section('scripts')

    <script>
        $('.nav-tabs a[data-toggle="tab"]').on('click', function(){
            var id = $('.nav-tabs li a.active').attr('href').split('#').pop();;
            $("#tabinput").val(id);
        })
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
    </script>

    {{-- ===========================================================================================
                                                VALIDACION
    =========================================================================================== --}}
    <script>
        var campos = ['name','description','permissions','rolBorrar'];
        ValidateAjaxRole("formEditRoles",campos,"btnSubmit","{{ route('roles.update',code($role->id) )}}","POST","/roles/edit/{{code($role->id)}}");

        function ValidateAjaxRole(idform,fields,buttonname,routeform,methodform,urlback){
            $("#"+idform+"").on('submit', function(e) {
                e.preventDefault();
                $("#"+idform+" .divWaitingMessage").slideDown();
                var registerForm = $("#"+idform+"");
                var formData = new FormData($("#"+idform+"")[0]);
                // var formData = registerForm.serialize();
                $.each(fields, function( indice, valor ) {
                    $("#"+valor+"-error").html( "" );
                    var inputtype = $("[name="+valor+"]").attr("type");
                    if(inputtype != 'radio')    $("[name="+valor+"]").removeClass('is-invalid').addClass('is-valid');
                    $("select[name="+valor+"]").removeClass('is-invalid-select').addClass('is-valid-select').removeClass('select2-selection');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").removeClass('is-invalid-select').addClass('is-valid-select');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").css('border','1px solid #5eba00');
                });
                $.ajax({
                    url: routeform,
                    type: methodform,
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:formData,
                    contentType: false,
                    processData: false,

                    success:function(data) {
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.alerta) {
                            toastr.error(data.mensaje);
                            $("[name="+buttonname+"]").attr('disabled',false)
                        }else if(data.success) {
                            console.log(data);
                            var contid = (data.contid) ? '?contid='+data.contid : "";

                            if (urlback === undefined || urlback === null)    location.reload(true);
                            else window.location.href = urlback+contid;
                            $("[name="+buttonname+"]").attr('disabled',true)
                        } else if(typeof(data.status) == "undefined"){
                            window.location.href = '/login';
                        }

                    },
                    error: function(data){
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.responseJSON.errors) {
                            var msjmail = ""; var sw_mail = 0;
                            $.each(data.responseJSON.errors, function( index, value ) {
                                $('#'+index+'-error' ).html( '&nbsp;<i class="fa fa-ban"></i> '+value );
                                $('#'+index+'').addClass('has-error');
                                var inputtype = $("[name="+index+"]").attr("type");
                                if(inputtype != 'radio')    $("[name="+index+"]").removeClass('is-valid').addClass('is-invalid');
                                $("select[name="+index+"]").removeClass('is-valid-select').addClass('is-invalid-select').removeClass('select2-selection');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").removeClass('is-valid-select').addClass('is-invalid-select');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").css('border','1px solid #cd201f');
                            });
                            var indexaux = []; var camposaux =[]; var i=0;
                            $.each(fields, function( indice, valor ) {
                                if(data.responseJSON.errors[valor]){
                                    indexaux[i] = indice;  i++;
                                }
                                var j = indice;
                                camposaux[j] = valor;
                            });
                            var menor = Math.min.apply(null, indexaux);
                            $('#'+camposaux[menor]+'--label')[0].scrollIntoView({behavior: 'smooth'});
                        }
                        setTimeout(function(){
                            $("[name="+buttonname+"]").attr('disabled',false);
                        }, 500)
                        if(typeof(data.status) != "undefined" && data.status != null && data.status == '401'){
                            window.location.href = '/login';
                        }
                    }
                });
            });
        }
    </script>

@endsection
