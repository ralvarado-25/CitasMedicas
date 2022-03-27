@push('extracss')

@endpush
<div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalCrearCitas" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Nueva cita</h5>
                <button type="button" class="btn-close text-primary" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open( array('route' =>'citas.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCreateCitas', 'onsubmit'=>'btnSubmit.disabled = true; return true;'))!!}
                <div class="row">
                    {!! datosRegistro('create') !!}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="paciente--label">* Paciente</label> <br>
                            <select class="form-control form-select" name="paciente" style="width:100%">
                                <option value="" hidden>Seleccionar</option>
                                @foreach ($usuarios as $user)
                                    <option value="{{$user->id}}"> {{userFullName($user->id)}}</option>
                                @endforeach
                            </select>
                            <span id="paciente-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="especialidad--label">* Especialidad</label> <br>
                            <select class="form-control form-select" name="especialidad" style="width:100%">
                                <option value="" hidden>Seleccionar</option>
                                @foreach ($especialidades as $esp)
                                    <option value="{{$esp->id}}"> {{$esp->nombre}}</option>
                                @endforeach
                            </select>
                            <span id="especialidad-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="fecha--label">* Fecha de cita</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" id="inputFecha" name="fecha" value="" placeholder="dd/mm/YYYY">
                            </div>
                            <span id="fecha-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="hora--label">* Hora de cita</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-clock"></i>
                                </span>
                                <input class="form-control input-incon timepicker" id="inputHora" name="hora" value="" placeholder="HH:mm">
                            </div>
                            <span id="hora-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control input-incon" name="fechahora" value="" id="inputFechaHora" style="display:none">
                        <center>
                            <b id="fechahora-error" class="text-red"></b>
                        </center>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="descripcion--label">Información adicional</label> <br>
                            <textarea name="descripcion"  rows="3" class="form-control" style="width:100%;resize:none"></textarea>
                            <span id="descripcion-error" class="text-red"></span>
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
        $("#inputFecha").change(function() {
            var fecha = $(this).val();
            var hora = $("#inputHora").val();
            hora = hora.length == '4' ? '0'+hora : hora;
            var fechahora = fecha+" "+hora;
            $("#inputFechaHora").val(fechahora);
        });
        $("#inputHora").change(function() {
            var hora = $(this).val();
            hora = hora.length == '4' ? '0'+hora : hora;
            var fecha = $("#inputFecha").val();
            var fechahora = fecha+" "+hora;
            $("#inputFechaHora").val(fechahora);
        });
    </script>

    <script>
        var campos = ['paciente','especialidad','fecha','hora','fechahora','descripcion'];
        ValidateAjax("formCreateCitas",campos,"btnSubmit","{{route('citas.store')}}","POST","/citas");
    </script>
@endpush