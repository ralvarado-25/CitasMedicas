@push('extracss')
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
@endpush
<div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalCrearEspecialidad" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Nueva especialidad</h5>
                <button type="button" class="btn-close text-primary" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open( array('route' =>'especialidades.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCreateEspecialidades', 'onsubmit'=>'btnSubmit.disabled = true; return true;'))!!}
                <div class="row">
                    {!! datosRegistro('create') !!}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="nombre--label">* Nombre de especialidad</label> <br>
                            <input class="form-control" name="nombre" type="text" placeholder="Nombre de nueva área">
                            <span id="nombre-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="duracion--label">* Duración aproximada (en horas)</label> <br>
                            <input class="form-control" name="duracion" type="text" placeholder="Duración aproximada del tratamiento">
                            <span id="duracion-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="descripcion--label">* Descripción</label> <br>
                            <textarea name="descripcion"  rows="3" class="form-control" style="width:100%;resize:none"></textarea>
                            <span id="descripcion-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 archivodiv" id="fileEspecialidades--label">
                        <b>Adjuntar imagen (.gif, .jpg, .jpeg, .png)</b><br>
                        <div id="fileEspecialidades_fg" class="form-group" style="margin:0; padding:0" >
                            <input type="file" class="input-sm" id="fileEspecialidades" name="fileEspecialidades" data-max-size="5192" data-browse-on-zone-click="true" accept=".gif, .jpg, .jpeg, .png">
                            <span id="fileEspecialidades-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary pull-right" name="btnSubmit">Registrar</button>
                    </div>
                </div>
                {{Form::Close()}}
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $("#fileEspecialidades").fileinput({
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
        $('#fileEspecialidades_fg .file-caption').click(function(){
            $('#fileEspecialidades').trigger('click');
        });
    </script>
    <script>
        var campos = ['nombre','duracion','descripcion','fileEspecialidades'];
        ValidateAjax("formCreateEspecialidades",campos,"btnSubmit","{{route('especialidades.store')}}","POST","/especialidades");
    </script>
@endpush