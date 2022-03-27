@push('extracss')

@endpush
<div class="modal modalDanger fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalExportar" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-pdf fa-lg"></i> Exportar Pdf</h5>
                <button type="button" class="btn-close text-primary" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open( array('route' =>'citas.export','method'=>'GET','autocomplete'=>'off','files'=>'true','id'=>'formExportCitas','target'=>'_blank'))!!}
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="selectFecha--label">* Fechas</label> <br>
                            <select class="form-control form-select" name="selectFecha" style="width:100%" id="selectFecha" required>
                                <option value="t">Todas</option>
                                <option value="r">Rango de fechas</option>
                            </select>
                            <span id="selectFecha-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divFechas" style="display: none">
                        <div class="form-group">
                            <label id="fechainicio--label">* Fecha de inicio</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" id="inputFechaInicio" name="fechainicio" value="" placeholder="dd/mm/YYYY">
                            </div>
                            <span id="fechainicio-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divFechas" style="display: none">
                        <div class="form-group">
                            <label id="fechafinal--label">* Fecha final</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" id="inputFechaFinal" name="fechafinal" value="" placeholder="dd/mm/YYYY">
                            </div>
                            <span id="fechafinal-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="pacientePDF--label">* Paciente</label> <br>
                            <select class="form-control form-select" name="pacientePDF" style="width:100%" required>
                                <option value="t">Todos</option>
                                @foreach ($usuarios as $user)
                                    <option value="{{$user->id}}"> {{userFullName($user->id)}}</option>
                                @endforeach
                            </select>
                            <span id="pacientePDF-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="especialidadPDF--label">* Especialidad</label> <br>
                            <select class="form-control form-select" name="especialidadPDF" style="width:100%" required>
                                <option value="t">Todas</option>
                                @foreach ($especialidades as $esp)
                                    <option value="{{$esp->id}}"> {{$esp->nombre}}</option>
                                @endforeach
                            </select>
                            <span id="especialidadPDF-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger pull-right font-weight-bold" name="btnSubmitExport">Exportar</button>
                    </div>
                </div>
                {{Form::Close()}}
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $("#selectFecha").change(function() {
            var val = $(this).val();
            console.log(val);
            if(val == 'r'){
                $(".divFechas").slideDown();
                $("#inputFechaInicio").prop('required',true);
                $("#inputFechaFinal").prop('required',true);
            }else{
                $(".divFechas").slideUp();
                $("#inputFechaInicio").prop('required',false);
                $("#inputFechaFinal").prop('required',false);
            }
        });
    </script>

    <script>
        // var campos = ['selectFecha','fechainicio','fechafinal','pacientePDF','especialidadPDF'];
        // ValidateAjax("formExportCitas",campos,"btnSubmitExport","{{route('citas.export')}}","POST","/citas");
    </script>
@endpush