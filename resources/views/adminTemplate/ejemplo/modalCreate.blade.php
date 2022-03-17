<div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalCreate" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa fa-plus"></i>&nbsp; Nuevo registro
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--
                    GUIA FORM
                    method: Se pone el tipo de metodo que se utizara en el formulario
                    action: Es la funcion del controlador a la cual se mandaran los datos del formulario
                    id: Funciona para validaciones cambiar el nombre al modulo que se usa
                    onsubmit: servira para bloquear el boton de submit para no generar varias peticiones
                --}}
                {!! Form::open( array('method'=>'POST', 'action' =>'EjemploController@store', 'id'=>'formPrograms', 'onsubmit'=>'btnSubmitPm.disabled = true; return true;')) !!}
                <div class="row">
                    {{-- Helper para mostrar datos de quien realiza el registro --}}
                    {!! datosRegistro('create') !!}

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="usuario--label">* Usuario</label> <br>
                            <select name="usuario" class="form-control form-select" required style="width: 100%">
                                <option value="" hidden>Seleccionar</option>
                                @foreach ($listaUsuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->ap_paterno}}</option>
                                @endforeach
                            </select>
                            <span id="usuario-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="fecha_ini--label">* Fecha de inicio</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" type="text" name="fecha_ini" placeholder="dd/mm/YYYY" required>
                            </div>
                            <span id="fecha_ini-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="fecha_fin--label">* Fecha Final</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" id="fecha_final_pm" type="text" name="fecha_fin" placeholder="dd/mm/YYYY" required>
                            </div>
                            <span id="fecha_fin-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" id="descripcion_fg">
                            <label id="descripcion--label">* Descripción</label> <br>
                            <textarea name="descripcion" rows="4" class="form-control" style="" placeholder="&#xf022; Descripción" required></textarea>
                            <span id="descripcion-error" class="text-red"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btnSubmitPm" id="regProy" class="btn btn-primary pull-right">Registrar</button>
                    </div>
                </div>
                {{Form::Close()}}
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
    </script>
@endpush