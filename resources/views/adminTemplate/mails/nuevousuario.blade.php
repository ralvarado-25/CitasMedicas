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
    @php
        $rutaLogo = public_path().'/logo.png';
    @endphp
    <table style="box-shadow: 1px 1px 4px 0 #e6e9ef; border-spacing: 0; overflow:hidden; display: block; margin:0 auto; background-color: #ffffff; width: 600px; max-width: 100%;">
        <thead style="background-color: gray; width: 600px; max-width:100%;">
            <tr>
                <th style="border-bottom: solid 5px gray; width: 600px; max-width: 100%; padding: 15px 30px; text-align: left; vertical-align: middle;">
                    <img id="imgempresa" alt="Amper" src="{{$rutaLogo}}" style="height: 50px">
                </th>
            </tr>
        </thead>
        <tbody style="width: 600px; max-width: 100%;">
            <tr>
                <td style="width: 600px; max-width: 100%; padding: 10px 30px; text-align: center; border-bottom: solid 2px  gray;">
                    <p style="color: #006699; margin: 0;"> <strong>ACCESOS PARA NUEVO USUARIO</strong></p>
                </td>
            </tr>
            <tr>
                <td style="width: 600px; max-width: 100%; padding: 10px 30px; word-break: break-word; line-height: 1.4;">
                    <p style="text-align:center; font-size:18px; margin-bottom:20px">
                        <b>Bienvenido </b> <br> {{$user->name}} {{$user->ap_paterno}}
                    </p>
                    <p style="margin-bottom:20px">
                        Ahora puede iniciar una sesión en nuestro sistema usando el siguiente nombre de usuario y la siguiente contraseña:
                    </p>
                    <p style="margin-left:80px">
                        <b>Nombre de Usuario: </b>{{$user->username}}
                    </p>
                    <p style="margin-left:80px;margin-bottom:20px">
                        <b>Contraseña: </b> {{$pass}}
                    </p>

                    <p style="margin: 0;">
                        Puede ingresar haciendo clic en este enlace o copiándolo y pegándolo en el navegador: <br>
                        <center>
                            <a href="{{ config('app.url') }}" target="_blank" style="color: #006699; font-size: 15px;" style="text-align:center;font-size:16px">admin.cmmshere.com/</a>
                        </center> <br>
                        <i> <b>DEBE</b> cambiar su contraseña cuando ingrese al Sistema</i>
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
