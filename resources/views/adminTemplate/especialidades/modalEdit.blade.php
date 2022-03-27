<style>
    .input-icon .form-control{
        height: 36px;
    }
    .file-drop-zone-title {
        padding: 0px !important;
    }
    .file-preview-frame{
        height: 150px;
    }
    .kv-file-content, .file-preview-other{
        height: 50px !important;
    }
    .file-other-icon{
        font-size: 3em !important
    }
    .krajee-default.file-preview-frame {
        left: 33%;
    }
    @media  (max-width: 991px){
        .krajee-default.file-preview-frame {
            left: 20%;
        }
    }
    @media  (max-width: 767px){
        .krajee-default.file-preview-frame {
            left: 0%;
        }
    }
    .file-caption-main, .kv-error-close{
        display: none !important;
    }
</style>
<link rel="stylesheet" href="{{asset('plugins/fileinput/css/fileinput.min.css')}}" media="all" type="text/css" />
<link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">
{{Form::Open(array('action'=>array('EspecialidadesController@update',code($esp->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditEspecialidad','onsubmit'=>'btnSubmitEdit.disabled = true; return true;' ))}}
    <div class="row">
        {!! datosRegistro('edit') !!}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="nombreedit--label">* Nombre de especialidad</label> <br>
                <input class="form-control" name="nombreedit" type="text" placeholder="Nombre de nueva área" value="{{$esp->nombre}}">
                <span id="nombreedit-error" class="text-red"></span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="duracionedit--label">* Duración aproximada (en horas)</label> <br>
                <input class="form-control" name="duracionedit" type="text" placeholder="Duración aproximada del tratamiento" value="{{$esp->duracion}}">
                <span id="duracionedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="descripcionedit--label">* Descripción</label> <br>
                <textarea name="descripcionedit"  rows="3" class="form-control" style="width:100%;resize:none">{!! $esp->descripcion !!}</textarea>
                <span id="descripcionedit-error" class="text-red"></span>
            </div>
        </div>

        @if (isset($esp->imagen) && $esp->imagen != '')
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <b>Ver imagen adjunta</b>
                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" title="Ver Imagen">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 9h8v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1z" />
                </svg>
                <a href="/storage/especialidad/{{$esp->imagen."?".rand()}}." target="_blanck">
                    <svg class="icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="15" y1="8" x2="15.01" y2="8" />
                        <rect x="4" y="4" width="16" height="16" rx="3" />
                        <path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" />
                        <path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" />
                    </svg>
                </a>
                <br>
                <label class="text-primary">
                    Cambiar imagen
                    @php
                        $textpopover ='data-toggle="popover" data-trigger="hover" data-content="<span style=\'font-size:11px\'>Al cambiar el archivo adjunto se <b>ELIMINARÁ</b> el que se guardó previamente para este registro </span>" data-title="<b>Información Importante</b>"';
                    @endphp
                    <span class="edithover form-help" {!! $textpopover !!}>?</span>
                </label>
                &nbsp;&nbsp; &nbsp; <input type="checkbox" class="cambioarchivo" name="cambioarchivo" value="1">
            </div>
        @endif

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 archivodiv" id="fileEspecialidadesEdit--label" @if (isset($esp->imagen) && $esp->imagen != '') style="display:none" @endif>
            <b>Adjuntar imagen (.gif, .jpg, .jpeg, .png)</b><br>
            <div id="fileEspecialidadesEdit_fg" class="form-group" style="margin:0; padding:0" >
                <input type="file" class="input-sm" id="fileEspecialidadesEdit" name="fileEspecialidadesEdit" data-max-size="5192" data-browse-on-zone-click="true" accept=".gif, .jpg, .jpeg, .png">
                <span id="fileEspecialidadesEdit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary pull-right" name="btnSubmitEdit">Modificar</button>
        </div>
    </div>
{{Form::Close()}}
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $("#fileEspecialidadesEdit").fileinput({
        showUpload: false,
        allowedFileExtensions: ["gif","jpg","jpeg","png"],
        maxFileSize: 5192,
        // Máximo tamaño a previsualizar
        maxFilePreviewSize: 5192,
        previewClass: "bg-fileinput",
        preferIconicPreview: true,
        previewFileIconSettings: {
            'docx': '<i class="fas fa-file-word text-primary"></i>',
            'xlsx': '<i class="fas fa-file-excel text-success"></i>',
            'pptx': '<i class="fas fa-file-powerpoint text-danger"></i>',
            'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            'zip': '<i class="fas fa-file-archive text-muted"></i>',
        },
        "fileActionSettings":{ "showZoom":true }
    });
    $('#fileEspecialidadesEdit_fg .file-caption').click(function(){
        $('#fileEspecialidadesEdit').trigger('click');
    });

    $('[data-toggle="popover"]').popover({
        html: true,
        "trigger" : "hover",
        "placement": "top",
        "container": "body",
    })

    $('.cambioarchivo').iCheck({
        checkboxClass: 'icheckbox_square-aero',
    }).on('ifChecked', function (event) {
        $('.archivodiv').slideDown();
    }).on('ifUnchecked', function (event){
        $('.archivodiv').slideUp();
    });
    if ($(".cambioarchivo").is(':checked')) {
        $('.archivodiv').slideDown();
    }
</script>
<script>
    var campos =['nombreedit','duracionedit','descripcionedit','cambioarchivo','fileEspecialidadesEdit'];
    ValidateAjax("formEditEspecialidad",campos,"btnSubmitEdit","{{ route('especialidades.update',code($esp->id) ) }}","POST","/especialidades");
</script>