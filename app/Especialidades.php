<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
    public function getCod(){
        if (1==1)
            return '<a rel="modalShow" style="cursor:pointer" href="/especialidades/'.code($this->id).'" title="Ver más detalles" data-toggle="tooltip">'.$this->cod.'</a>';
        else
            return $this->cod;
    }

    public function getEstado(){
        if ($this->activo==1) {
            $estado =
            '<span class="text-teal">
                <i class="fas fa-check-circle fa-lg"></i>&nbsp;<b>Activa</b>
            </span>';
        } else {
            $estado =
            '<span class="text-pink">
                <i class="fas fa-exclamation-circle fa-lg"></i>&nbsp;<b>Inactiva</b>
            </span>';
        }
        return $estado;
    }
}
