<div class="modal-header">
    <h5 class="modal-title font-weight-bold">
        Cambio de estado cita: {!! $cita->cod !!}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    {{ Form::Open(['action' => ['CitasController@updateState', code($cita->id)], 'method' => 'POST', 'autocomplete' => 'off', 'id' => 'formStateCita', 'onsubmit'=>'btnSubmitState.disabled = true; return true;']) }}
        <div class="row" style="padding-left:10px">
            <div class="form-selectgroup-boxes row" id="checkstate--label">
                @if ($swdisp == 0)
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label class="form-selectgroup-item ">
                            <input type="radio" name="checkstate" value="1" class="form-selectgroup-input" id="radiovali">
                            <span class="form-selectgroup-label d-flex align-items-center p-3 ">
                                <span class="form-selectgroup-label-content">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-title font-weight-bold mb-1 text-success">
                                        Validar cita
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endif

                @if($swdisp == 1)
                    <b class="text-orange" style="font-size:12px">No puede AUTORIZAR la cita </b> <br>
                    <span class="text-muted" style="font-size:12px" >
                        La fecha registrada <b>{{ date("d/m/Y",strtotime($cita->fecha)) }}</b> ya esta ocupada</b>.
                    </span>
                @endif

                <div class="@if ($swdisp == 0) col-lg-6 col-md-6 @else col-lg-12 col-md-12 @endif col-sm-12 col-xs-12">
                    <label class="form-selectgroup-item">
                        <input type="radio" name="checkstate" value="2" class="form-selectgroup-input" id="radioanul">
                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                            <span class="form-selectgroup-label-content">
                                <span class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-title font-weight-bold mb-1 text-red">
                                    Anular cita
                                </span>
                            </span>
                        </span>
                    </label>
                </div>
                <center><span id="checkstate-error" class="text-red font-weight-bold"></span></center>
            </div>

            <div class="row" style="margin-top:20px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 validdiv">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title pull-left ">
                                <b>Resumen&nbsp;</b>
                            </h5>
                            <table class="table table-sm ">
                                <tbody>
                                    <tr>
                                        <td width="50%" class="font-weight-bold">Paciente</td>
                                        <td>{!! userFullName($cita->user_id) !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" class="font-weight-bold">Especialidad</td>
                                        <td>{!! $cita->especialidades->nombre !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" class="font-weight-bold">Fecha y hora de cita</td>
                                        <td>{!! date("d/m/Y H:i",strtotime($cita->fecha)) !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 anulardiv" style="display:none">
                <div class="form-group">
                    <label id="motivo--label">Motivo de anulación</label><br>
                    <textarea name="motivo" class="form-control" style="width:100%;resize:none" rows="3"></textarea>
                    <span id="motivo-error" class="text-red"></span>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px">
                <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary pull-right" name="btnSubmitState">Actualizar estado</button>
            </div>
        </div>

        </div>
    {{ Form::Close() }}
</div>

<script>
    $("#radiovali").change(function() {
        if($(this).is(":checked")) {
            $(".validdiv").slideDown();
            $(".anulardiv").slideUp();
        }
    });
    $("#radioanul").change(function() {
        if($(this).is(":checked")) {
            $(".validdiv").slideUp();
            $(".anulardiv").slideDown();
        }
    });

    var statefields = ["checkstate","motivo"];
    ValidateAjax("formStateCita",statefields,"btnSubmitState","{{ route('citas.state',code($cita->id) )}}","POST","/citas");
</script>
