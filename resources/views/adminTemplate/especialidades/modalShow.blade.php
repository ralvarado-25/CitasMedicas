<div class="modal-header">
    <h5 class="modal-title font-weight-bold">
        Especialidad: {{ $esp->nombre }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row" style="padding-left:10px">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 validdiv">
            <h5 class="card-title pull-left ">
                <b>Datos generales&nbsp;</b>
            </h5>
            <table class="table table-sm ">
                <tbody>
                    <tr>
                        @php
                            $routeAttach = storage_path('app/public/especialidad/'.$esp->imagen);
                        @endphp
                        @if (isset($esp->imagen) && file_exists($routeAttach))
                            <td colspan="2">
                                @php
                                    $ruta = '/storage/especialidad/'.$esp->imagen."?".rand();
                                @endphp
                                <center>
                                    <a href="{{$ruta}}" target="_blank">
                                        <img class="img-rounded" style="max-width: 40%; margin-left: auto; margin-right: auto; display: block;" src="{{ $ruta }}">
                                    </a>
                                </center>
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td width="50%" class="font-weight-bold">Registrado por</td>
                        <td>{!! userFullName($esp->user_id) !!}</td>
                    </tr>
                    <tr>
                        <td width="50%" class="font-weight-bold">Código</td>
                        <td>{!! $esp->cod !!}</td>
                    </tr>
                    <tr>
                        <td width="50%" class="font-weight-bold">Descripción</td>
                        <td>{!! $esp->descripcion !!}</td>
                    </tr>
                    <tr>
                        <td width="50%" class="font-weight-bold">Duración aproximada</td>
                        <td>{!! $esp->duracion !!} Horas</td>
                    </tr>
                    <tr>
                        <td width="50%" class="font-weight-bold">Estado</td>
                        <td>{!! $esp->duracion !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <button type="button" class="btn btn-ghost-secondary pull-right border border-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>

