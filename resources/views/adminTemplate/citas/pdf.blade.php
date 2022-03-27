<html>
    <head>
        <meta charset="UTF-8">
        <title>Reporte de citas</title>

        <style>
            table.tablaEjemplo td.conb ,th{
                border: solid 1px black;
                padding: 5px;
            }
            .conb{
                border: solid 1px black;
                padding: 5px;
            }
            .center{
                text-align:center;
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
                            <img src="{{$rutaLogo}}" style="max-width: 150px; max-height: 150px">
                        </td>
                    </tr>
                </table>
                <br>
                <table style="font-size: 18px; width: 100%; " >
                    <tr>
                        <td colspan="8">
                            <span  style="font-size: 22px;"> <center> <b> LISTADO DE CITAS </b> </center></span>
                        </td>
                    </tr>
                </table>
                <br><br>

                <table id="tablaEjemplo" style="width: 100%; border-collapse: collapse; border-spacing: 0;" >
                    <tr>
                        <th class="text-center" width="10%">Código</th>
                        <th class="text-center" width="20%">Paciente</th>
                        <th class="text-center" width="10%">Especialidad</th>
                        <th class="text-center" width="10%">Fecha y hora de consulta</th>
                        <th class="text-center" width="25%" style="text-align:center !important">Descripción</th>
                        <th class="text-center" width="10%">Estado</th>
                    </tr>
                    @foreach ($citas as $cita)

                        @php
                            $estado = '';
                            switch ($cita->estado) {
                                case '2': $estado = 'Anulado';    break;
                                case '1': $estado = 'Validado';    break;
                                case '0': $estado = 'Pendiente';    break;
                                default: $estado = '';    break;
                            }
                        @endphp
                        <tr class="conb">
                            <td class="conb"> {{$cita->cod}} </td>
                            <td class="conb"> {{userFullName($cita->user_id)}} </td>
                            <td class="conb"> {!! $cita->especialidades->nombre !!} </td>
                            <td class="conb center"> {{date("d/m/Y",strtotime($cita->fecha))}} <br> {{date("h:i",strtotime($cita->fecha))}} </td>
                            <td class="conb" style="font-size:11px;text-align:justify"> {!!$cita->descripcion  !!} </td>
                            <td class="conb"> {!! $estado !!} </td>
                        </tr>

                    @endforeach

                </table>

            </div>
        </div>
    </body>
    </html>


