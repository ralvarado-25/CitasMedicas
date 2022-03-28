<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mail Dentalife</title>
    <style>
        body{
            margin-top:20px;
        }
        .fontFamily{
            font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }
        .buttonLink{
            color: #FFF;
            text-decoration: none;
            line-height: 2em;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
            text-transform: capitalize;
            background-color: #3fbbc0;
            margin: 0;
            border-color: #3fbbc0;
            border-style: solid;
            border-width: 8px 16px;
        }
        .urlClass{
            font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
            box-sizing: border-box;
            font-size: 12px;
            color: #999;
            text-decoration: underline;
            margin: 0;
        }
    </style>
</head>


<body style="background-color: #ffffff; color:#8798ad; font-family: 'Roboto', Helvetica, sans-serif; font-size: 14px; padding: 30px 20px; margin: 0;">
    @php
        $rutaLogo = public_path().'/logo.png';
    @endphp
    <table class="body-wrap fontFamily" style="width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tbody>
            <tr class="fontFamily" style="margin: 0;">
                <td class="fontFamily" style="vertical-align: top; margin: 0;" valign="top"></td>
                <td class="container fontFamily" width="600" style="vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                    valign="top">
                    <div class="content fontFamily" style="max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                        <table class="main fontFamily" width="100%" cellpadding="0" cellspacing="0" style="border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                            <tbody>
                                <tr class="fontFamily" style="margin: 0;">
                                    <td class="fontFamily" style="font-size:18px !important; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #38414a; margin: 0; padding: 20px;"align="center" bgcolor="#71b6f9" valign="top">
                                        <img id="imgempresa" alt="Dentalife" src="http://drive.google.com/uc?export=view&id=1alh0KAADNdpQS5r_hv80UqNh9Nrv2sXy" style="height: 80px">
                                        <b style="margin-top: 10px;display: block;font-size:18px">Informe de reserva de cita odontologica.</b>
                                    </td>
                                </tr>
                                <tr class="fontFamily" style="margin: 0;">
                                    <td class="content-wrap fontFamily" style="vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                        <table class="fontFamily" width="100%" cellpadding="0" cellspacing="0" style="margin: 0;">
                                            <tbody>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        <center>
                                                            @if ($cita->estado == '1')
                                                                <b style="font-size:16px;color:#3FBBC0">CITA VALIDADA</b>
                                                            @else
                                                                <b style="font-size:16px;color:#d63939">CITA ANULADA</b>
                                                            @endif
                                                        </center>
                                                    </td>
                                                </tr>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        @if (isset($cita->origen) && $cita->origen != "")
                                                            <b>Paciente: </b> <i>Los datos generales se encuentran en la descripción</i>
                                                        @else
                                                            <b>Paciente: </b> {{userFullName($cita->user_id)}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        <b>Codigo de cita: </b> {{$cita->cod}}
                                                    </td>
                                                </tr>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        <b>Especialidad: </b> {{$cita->especialidades->nombre}}
                                                    </td>
                                                </tr>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        <b>Fecha y hora de cita: </b> {{ date("d/m/Y H:i",strtotime($cita->fecha))}}
                                                    </td>
                                                </tr>
                                                <tr class="fontFamily" style="margin: 0;">
                                                    <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                        <b>Descripción: </b> <br> {!! $cita->descripcion !!}
                                                    </td>
                                                </tr>
                                                @if ($cita->estado == '2')
                                                    <tr class="fontFamily" style="margin: 0;">
                                                        <td class="content-block fontFamily" style="vertical-align: top; margin: 0; padding: 0 0 20px; font-size:14px" valign="top">
                                                            <b>Motivo de anulación: </b> {!! $motivo !!}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="footer fontFamily" style="width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                            <table width="100%" class="fontFamily" style="margin: 0;">
                                <tbody>
                                    <tr class="fontFamily" style="margin: 0;">
                                        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 10px;" align="center" valign="top">
                                            <b>Notificación enviada por: </b> {{userFullname(userId())}}
                                        </td>
                                    </tr>
                                    <tr class="fontFamily" style="margin: 0;">
                                        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 10px;" align="center" valign="top">
                                            <b>Fecha de notificación: </b> {{date("d/m/Y H:i")}}
                                        </td>
                                    </tr>
                                    <tr class="fontFamily" style="margin: 0;">
                                        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 10px;" align="center" valign="top">
                                            <a href="http://127.0.0.1:8000/" class="urlClass" target="_blank">
                                                <b>www.dentalife.com.bo</b>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="fontFamily" style="vertical-align: top; margin: 0;" valign="top"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>