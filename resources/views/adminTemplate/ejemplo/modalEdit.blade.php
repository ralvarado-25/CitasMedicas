<div class="modal modalPrimary fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalEdit-{{$ejemplo->id}}" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa fa-plus"></i>&nbsp; Editar {{ $ejemplo->cod }}
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="pull:left !important">
                {{--
                    GUIA FORM
                    method: Se pone el tipo de metodo que se utizara en el formulario
                    action: Es la funcion del controlador a la cual se mandaran los datos del formulario en este caso es array porque se debe enviar el parametro de que registro se esta modificando
                            array('EjemploController@update',code($ejemplo->id))
                    id: Funciona para validaciones cambiar el nombre al modulo que se usa
                    onsubmit: servira para bloquear el boton de submit para no generar varias peticiones
                --}}
                {!! Form::open( array('method'=>'POST', 'action'=>array('EjemploController@update',code($ejemplo->id)), 'autocomplete'=>'off','id'=>'formEjemploEdit', 'onsubmit'=>'btnSubmitEditEjemplo.disabled = true; return true;')) !!}
                <div class="row">
                    {!! datosRegistro('edit') !!}

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="usuarioedit--label">* Usuario</label> <br>
                            <select name="usuarioedit" class="form-control form-select" required style="width: 100%">
                                <option value="" hidden>Seleccionar</option>
                                @foreach ($listaUsuarios as $usuario)
                                    @if ($usuario->id == $ejemplo->user_id)
                                        <option value="{{$usuario->id}}" selected>{{$usuario->name}} {{$usuario->ap_paterno}}</option>
                                    @else
                                        <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->ap_paterno}}</option>
                                    @endif

                                @endforeach
                            </select>
                            <span id="usuarioedit-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="fecha_iniedit--label">* Fecha de inicio</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" type="text" name="fecha_iniedit" placeholder="dd/mm/YYYY" value="{{ date("d/m/Y",strtotime($ejemplo->start_date) ) }}" >
                            </div>
                            <span id="fecha_iniedit-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="fecha_finedit--label">* Fecha Final</label> <br>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i id="iconForm" class="far fa-calendar-alt"></i>
                                </span>
                                <input class="form-control input-incon datepicker" type="text" name="fecha_finedit" placeholder="dd/mm/YYYY" value="{{ fechaConv($ejemplo->end_date) }}" >
                            </div>
                            <span id="fecha_finedit-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label id="descripcionedit--label">* Descripción</label> <br>
                            <textarea name="descripcionedit" rows="4" class="form-control" placeholder="&#xf022; Descripción">{!! $ejemplo->description !!}</textarea>
                            <span id="descripcionedit-error" class="text-red"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btnSubmitEditEjemplo" class="btn btn-primary pull-right">Modificar</button>
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