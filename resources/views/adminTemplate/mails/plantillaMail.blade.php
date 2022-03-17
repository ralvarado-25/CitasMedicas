<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mail Dentalife</title>
    <style>

    </style>
</head>


<body style="background-color: #ffffff; color:#8798ad; font-family: 'Roboto', Helvetica, sans-serif; font-size: 14px; padding: 30px 20px; margin: 0;">

    <table style="box-shadow: 1px 1px 4px 0 #e6e9ef; border-spacing: 0; overflow:hidden; display: block; margin:0 auto; background-color: #ffffff; width: 600px; max-width: 100%;">
        <thead style="background-color: gray; width: 600px; max-width:100%;">
            <tr>
                <th style="border-bottom: solid 5px gray; width: 600px; max-width: 100%; padding: 15px 30px; text-align: left; vertical-align: middle;">
                    <img id="imgempresa" alt="Amper" src="{{asset('logo.png')}} " style="height: 50px">
                </th>
            </tr>
        </thead>
        <tbody style="width: 600px; max-width: 100%;">
            <tr>
                <td style="width: 600px; max-width: 100%; padding: 10px 30px; text-align: center; border-bottom: solid 2px  gray;">
                    <p style="color: #006699; margin: 0;"> <strong>RESERVA CITA EJEMPLO</strong></p>
                </td>
            </tr>
            <tr>
                <td style="width: 600px; max-width: 100%; padding: 10px 30px; word-break: break-word; line-height: 1.4;">

                    <p style="margin: 0;">
                        <b> Cliente: </b> <span class="datos1"> Carla Mendoza </span>
                    </p>
                    <p style="margin: 0;">
                        <b>Dirección: </b> <span class="datos1">Zona Central Nº 2727</span>
                    </p>
                    <p style="margin: 0;">
                        <b>Fecha de cita: </b> <span class="datos1">12/12/2022</span>
                    </p>

                    <p style="margin: 0;">
                        <b>Hora de cita: </b> <span class="datos1">16:30</span>
                    </p>

                    <p style="margin: 0;">
                        <b>Especialidad: </b> <span class="datos1">Endodoncia</span>
                    </p>

                    <hr style="border-top: solid 1px #eff3f9; margin:10px 0;">
                    <p style="margin: 0;">
                        <b>MENSAJE ADICIONAL: </b> <span class="datos1">Recuerde estar 15 minutos antes de la hora de cita</span>
                    </p>
                </td>
            </tr>
        </tbody>
        <tfoot style="background-color: #eff3f9; font-size: 12px; width: 600px; max-width: 100%; text-align: center;">
            <tr>
                <td style="border-bottom: solid 1px #c9d7df; padding: 10px 30px;">
                        <p style="margin: 0; font-weight: bold;">NOTIFICACIÓN ENVIADA POR: <span>{{userFullname(userId())}}</span></p>
                        <p style="margin: 0; font-weight: bold;">FECHA DE NOTIFICACIÓN: <span>{{date("d/m/Y H:i")}}</span> </p>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 30px;">
                    <p style="margin: 0;">
                        <a href="http://127.0.0.1:8000/" target="_blank" style="color: #006699; font-size: 13px;">www.dentalife.com.bo</a>
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
