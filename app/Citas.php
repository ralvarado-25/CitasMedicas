<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    public function especialidades(){
        return $this->belongsTo(Especialidades::class, 'especialidad_id');
    }

    public function getFechaHora(){
        if(isset($this->fecha) && $this->fecha != ''){
            $fecha = date("d/m/Y",strtotime($this->fecha));
            $hora = date("H:i",strtotime($this->fecha));
            return $fecha.'<br>'.$hora;
        }
        return '';
    }

    public function getEstado($estilos){
        switch ($this->state) {
            case '0':
                $val = "Pendiente";
                if( 1 == 1 )
                    $fin =
                    '<a rel="modalState" href="/programs/statemodal/'.code($this->id).'" class="text-yellow" title="Cambiar estado">
                        <i class="fa fa-refresh fa-spin"></i><br> '.$val.'
                    </a>';
                else
                    $fin =
                    '<span class="text-yellow">
                        <i class="fa fa-refresh fa-spin"></i><br> '.$val.'
                    </span>';
                break;
            case '1':
                $val = "Terminado";
                $fin =
                    '<div class="p-2 text-center input-sm" style="height: 100%;" >
                        <span class="text-green"><i class="fa fa-check"></i> ' . $val . '</span>
                    </div>';
                break;
            default:
                $val = "Desconocido";
                $fin = '<div class="p-2 text-center input-sm" style="height: 100%;"><span class="text-muted"> <i class="fas fa-question"></i> ' . $val . '</span></div>';
                break;
        }
        return $estilos == 1 ? $fin : $val;
    }
}
