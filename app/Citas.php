<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

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
        switch ($this->estado) {
            case '0':
                $val = "Pendiente";
                if( Gate::check('citas.validar') )
                    $fin =
                    '<a rel="modalState" href="/cita/modalCambEstado/'.code($this->id).'" class="text-yellow" title="Cambiar estado" data-toggle="tooltip">
                        <i class="fa fa-refresh fa-spin"></i><br> '.$val.'
                    </a>';
                else
                    $fin =
                    '<span class="text-yellow">
                        <i class="fa fa-refresh fa-spin"></i><br> '.$val.'
                    </span>';
                break;
            case '1':
                $val = "Validada";
                $fin =
                    '<div class="p-2 text-center input-sm" style="height: 100%;" >
                        <span class="text-green"><i class="fa fa-check"></i> ' . $val . '</span>
                    </div>';
                break;
            case '2':
                $val = "Anulada";
                $fin =
                    '<div class="p-2 text-center input-sm" style="height: 100%;">
                        <span class="text-red"><i class="fa fa-ban text-danger"></i> ' . $val . '</span>
                    </div>';
                break;
            default:
                $val = "Desconocido";
                $fin = '<div class="p-2 text-center input-sm" style="height: 100%;"><span class="text-muted"> <i class="fas fa-question"></i> ' . $val . '</span></div>';
                break;
        }
        return $estilos == 1 ? $fin : $val;
    }

    public function getColor(){
        switch ($this->estado){
            case '0':
                $val = "#edb66a";
            break;
            case '1':
                $val = "#66c474";
            break;
            case '2':
                $val = "#d63939";
            break;
            default:
                $val = "#2a3942";
            break;
        }
        return $val;

    }

    public function scopeRangeDate($query,$start,$final, $type){
        if($start != '' && $final != '' && $type == 'r'){
            $query->whereBetween('fecha', [$start, $final]);
        }
    }

    public function scopeEspecialidad($query,$val){
        if ($val != "" && $val != "t") {
            $query->whereHas('especialidades', function ($rq) use ($val) {
                $rq->where('id', $val);
            });
        }
    }

    public function scopePaciente($query, $id){
        if($id != "" && $id != 't'){
            $query->where('user_id', $id);
        }
    }

    public function scopeUserPerm($query){
        if ( Gate::check('citas.index')!='1') {
            $query->where('user_id',userId());
        }
    }
}
