{{Form::Open(array('action'=>array('CitasController@update',code($cita->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditCitas' ))}}
<div class="row">
    {!! datosRegistro('edit') !!}
    @if (Gate::check('citas.index'))
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="pacienteedit--label">* Paciente</label> <br>
                <select class="form-control form-select" name="pacienteedit" style="width:100%">
                    <option value="" hidden>Seleccionar</option>
                    @foreach ($usuarios as $user)
                        <option value="{{$user->id}}" @if($user->id == $cita->user_id) selected @endif> {{userFullName($user->id)}}</option>
                    @endforeach
                </select>
                <span id="pacienteedit-error" class="text-red"></span>
            </div>
        </div>
    @else
        <input type="text" value="{{userId()}}" name="pacienteedit" style="display: none">
    @endif
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="especialidadedit--label">* Especialidad</label> <br>
            <select class="form-control form-select" name="especialidadedit" style="width:100%">
                <option value="" hidden>Seleccionar</option>
                @foreach ($especialidades as $esp)
                    <option value="{{$esp->id}}" @if($esp->id == $cita->especialidad_id) selected @endif> {{$esp->nombre}}</option>
                @endforeach
            </select>
            <span id="especialidadedit-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="fechaedit--label">* Fecha de cita</label> <br>
            <div class="input-icon">
                <span class="input-icon-addon">
                    <i id="iconForm" class="far fa-calendar-alt"></i>
                </span>
                <input class="form-control input-incon datepicker" id="inputFechaEdit" name="fechaedit" value="{{date("d/m/Y",strtotime($cita->fecha))}}" placeholder="dd/mm/YYYY">
            </div>
            <span id="fechaedit-error" class="text-red"></span>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="horaedit--label">* Hora de cita</label> <br>
            <div class="input-icon">
                <span class="input-icon-addon">
                    <i id="iconForm" class="far fa-clock"></i>
                </span>
                <input class="form-control input-incon timepicker" id="inputHoraEdit" name="horaedit" value="{{date("H:i",strtotime($cita->fecha))}}" placeholder="HH:mm">
            </div>
            <span id="horaedit-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input class="form-control input-incon" name="fechahoraedit" value="{{date("d/m/Y H:i",strtotime($cita->fecha))}}" id="inputFechaHoraEdit" style="display:none" >
        <center>
            <b id="fechahoraedit-error" class="text-red"></b>
        </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="descripcionedit--label">Información adicional</label> <br>
            <textarea name="descripcionedit"  rows="3" class="form-control" style="width:100%;resize:none">{!!$cita->descripcion!!}</textarea>
            <span id="descripcionedit-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary pull-right" name="btnSubmitEdit">Modificar</button>
    </div>
</div>
{{Form::Close()}}


<script>
    $("#inputFechaEdit").change(function() {
        var fecha = $(this).val();
        var hora = $("#inputHoraEdit").val();
        hora = hora.length == '4' ? '0'+hora : hora;
        var id = "{{code($cita->id)}}";
        var fechahora = fecha+" "+hora+" "+id;
        $("#inputFechaHoraEdit").val(fechahora);
    });
    $("#inputHoraEdit").change(function() {
        var hora = $(this).val();
        hora = hora.length == '4' ? '0'+hora : hora;
        var fecha = $("#inputFechaEdit").val();
        var id = "{{code($cita->id)}}";
        var fechahora = fecha+" "+hora+" "+id;
        $("#inputFechaHoraEdit").val(fechahora);
    });
    $('.datepicker').datepicker({
        autoclose: true,
        width: '100%',
        format: 'dd/mm/yyyy',
        ignoreReadonly: true,
        todayHighlight: true
    });
    $('.timepicker').timepicker({
        showInputs: false,
        minuteStep: 60,
        showMeridian: false,
        defaultTime: null
    });

    var campos =['pacienteedit','especialidadedit','fechaedit','horaedit','fechahoraedit','descripcionedit'];
    ValidateAjax("formEditCitas",campos,"btnSubmitEdit","{{ route('citas.update',code($cita->id) ) }}","POST","/citas");
</script>
