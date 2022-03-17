<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejemplo extends Model
{
    // Nombre de la tabla en la BD a donde se tendra acceso desde este modelo
    protected $table = 'ejemplo';

    //    RELACIONES a otros modelos (tablas)
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getEstado(){
        if ($this->state==1) {
            $estado =
            '<a href="/ejemplo/state/'.code($this->id).'/1" >
                <span class="text-teal" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<span class=\'text-teal\' style=\'font-size: 12px;\'> Si desea desactivar el registro haga clic. </span>" data-original-title="<span class=\'text-teal\' style=\'font-size: 12px;\'><b>REGISTRO ACTIVO</b></span>">
                    <i class="fas fa-check-circle fa-lg"></i>&nbsp;<b>Activo</b>
                </span>
            </a>';
        } else {
            $estado =
            '<a href="/ejemplo/state/'.code($this->id).'/0">
                <span class="text-pink" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<span class=\'text-pink\' style=\'font-size: 12px\'> Si desea activar el registro haga clic. </span>" data-original-title="<span class=\'text-pink\' style=\'font-size: 12px\'><b>REGISTRO INACTIVO</b></span>">
                    <i class="fas fa-exclamation-circle fa-lg"></i>&nbsp;<b>Inactivo</b>
                </span>
            </a>';
        }
        return $estado;
    }
}
