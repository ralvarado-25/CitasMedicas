<html>
    <head>
        <meta charset="UTF-8">
        <title>Papeleta de Pago</title>

        <style>
            table.tablaEjemplo td.conb ,th{
                border: solid 1px black;
                padding: 5px;
            }
            .conb{
                border: solid 1px black;
                padding: 5px;
            }
        </style>

    </head>
    <body >
        @php
            $rutaLogo = public_path().'/logo.png';
        @endphp
        <div> {{-- DIV QUE ENCIERRA A TODO EL PDF --}}
            <div style="page-break-inside: avoid;">
                <table >
                    <tr>
                        <td  width="90%" style="font-size:18px">
                            <b>
                                Dentalife <br>
                                NIT: 226564676213
                            </b>
                        </td>
                        <td width="10%"  style="padding-left:200px" >
                            <img src="{{$rutaLogo}}" style="max-width: 130px; max-height: 130px">
                        </td>
                    </tr>
                </table>

                <table style="font-size: 18px; width: 100%; " >
                    <tr>
                        <td colspan="8">
                            <span  style="font-size: 22px;"> <center> <b> LISTA DE EJEMPLO </b> </center></span>
                            <hr>
                        </td>
                    </tr>
                </table>

                <table id="tablaEjemplo" style="width: 100%; border-collapse: collapse; border-spacing: 0;" >
                    <tr>
                        <th class="text-center" width="10%">Código</th>
                        <th class="text-center" width="20%">Usuario</th>
                        <th class="text-center" width="10%">Fecha inicial</th>
                        <th class="text-center" width="10%">Fecha final</th>
                        <th class="text-center" width="25%" style="text-align:center !important">Descripción</th>
                        <th class="text-center" width="10%">Estado</th>
                    </tr>
                    @foreach ($listaEjemplos as $ejemplo)
                        @php
                            $estado = '';
                            switch ($ejemplo->state) {
                                case '1': $estado = 'Activo';    break;
                                case '0': $estado = 'Inactivo';    break;
                                default: $estado = '';    break;
                            }
                        @endphp
                        <tr class="conb">
                            <td class="conb"> {{$ejemplo->cod}} </td>
                            <td class="conb"> {{$ejemplo->usuario->name}} {{$ejemplo->usuario->ap_paterno}} </td>
                            <td class="conb"> {{fechaConv($ejemplo->start_date)}} </td>
                            <td class="conb"> {{fechaConv($ejemplo->end_date)}} </td>
                            <td class="conb" style="font-size:11px;text-align:justify"> {!!$ejemplo->description  !!} </td>
                            <td class="conb"> {!! $estado !!} </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </body>
    </html>


