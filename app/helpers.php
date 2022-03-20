<?php

use App\Permission;
use App\User;

/**
 * Devuelve el número de id del usuario conectado
* @return int $id
*/
function userId(){
return auth()->user()->id;
}

function layoutUser(){
    return isset( auth()->user()->layout ) ? auth()->user()->layout[1] : "R";
}

function themeMode(){
    return isset( auth()->user()->layout ) ? auth()->user()->layout[0] : "L";
}

/**
 * Devuelve el id encriptado
* @param int $id es el numero que será encriptado
* @return int $id
*/
function code($id){
    return \Hashids::encode($id);
}

/**
 * Devuelve el id desencriptado
* @param int $id es el numero que se encuentra encriptado
* @return int $id
*/
function decode($id){
    $deco = \Hashids::decode($id);
    return count($deco) == 0 ? 0 : \Hashids::decode($id)[0];
}

/**
 * Devuelve el nombre y el apellido paterno de un usuario
 * @param  int $id ID del usuario del cual que quiere obtener su nombre
 * @return string $user_name
 */
function userFullName($id){
    if(isset($id)){
        $user = User::select('name','ap_paterno','ap_materno')->whereId($id)->first();
        return isset($user) ? $user->name." ".$user->ap_paterno." ".$user->ap_materno : "Usuario desconocido";
    }else
        return "Sin usuario asignado";
}

// Ruta para obtener el avatar
// $name: nombre del avatar en la tabla Users
// $swT: 1 obtener el thumbnail, 0: obtener tamaño grande
function imageRouteAvatar($name,$swT){
    $routeAttach = storage_path('app/public/general/avatar/'.$name);
    $routeAttachThumb = storage_path('app/public/general/avatar/thumbnail/'.$name);
    if($swT == 1){
        if (isset($name) && file_exists($routeAttachThumb))
            $ruta = '/storage/general/avatar/thumbnail/'.$name."?".rand();
        else
            $ruta = '/storage/thumbnail/avatar0.png?'.rand();
    }else{
        if (isset($name) && file_exists($routeAttach))
            $ruta = '/storage/general/avatar/'.$name."?".rand();
        else
            $ruta = '/storage/avatar0.png?'.rand();
    }
    return $ruta;
}

/**
 * Convierte la fecha de entrada dd/mm/YYYY a YYYY-mm-dd
* @param date $fechaEntreda  es la fecha de entrada del dataTable
* @return date $fechaSalida  es la fecha de salida para el filtro
*/
function convFechaDT($fechaInicial){
    $fechaFinal=explode("/",$fechaInicial);
    switch (count($fechaFinal)) {
        case '1':   return $fechaFinal[0];  break;
        case '2':   return $fechaFinal[1]."-".$fechaFinal[0];   break;
        case '3':   return $fechaFinal[2]."-".$fechaFinal[1]."-".$fechaFinal[0];    break;
        default:    return "";  break;
    }
}


/**
 * Devuelve los permisos
 * @return array $permisos el listado de los permisos
 */
function getPermisos($id){
    return Permission::where('parent_id',$id)->where('active','1')->orderBy('id','desc')->get();
}

function permisoName($id){
    $perm = Permission::find($id);
    return isset($perm) ? $perm->description : "";
}

function purify($val){
    return \Purify::clean($val);
}

function datosRegistro($type){
    $titulo = $type == 'edit' ? 'Modificado por' : 'Registrado por';
    $fecha = $type == 'edit' ? 'Fecha de modificación' : 'Fecha de registro';
    return  '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>'.$titulo.'</label> <br>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i id="iconForm" class="fas fa-user"></i>
                        </span>
                        <input class="form-control input-incon cursor-not-allowed" value="'.userFullName(userId()).'" disabled>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>'.$fecha.'</label> <br>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i id="iconForm" class="far fa-calendar-alt"></i>
                        </span>
                        <input class="form-control input-incon cursor-not-allowed" type="text" value="'.date("d/m/Y").'" disabled>
                    </div>
                </div>
            </div>';

}

function generateCode($maximo,$code,$letter,$cant_letras,$zero){
    if($maximo==null){
        $cod = $code;
    }else{
        $cont = substr($maximo, $cant_letras);
        $cont = $cont+1;
        $codConCeros = str_pad($cont, $zero,"0", STR_PAD_LEFT);
        $cod = $letter.$codConCeros;
    }
    return $cod;
}

function fechaConv($fecha){
    return isset($fecha) && $fecha != '' ? date("d/m/Y",strtotime($fecha)) : '';
}

function userMail($id){
    if (isset($id)) {
        $user = User::whereId($id)->first();
        return isset($user) ? $user->email : "";
    }
    return "";
}
