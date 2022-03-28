<?php

namespace App\Http\Controllers;

use App\Citas;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        Session::put('item', '0.');
        return view('adminTemplate.home');
    }

    public function datesAjax(Request $request){
        $start = date('Y-m-d H:i',strtotime($request->start));
        $end = date('Y-m-d',strtotime($request->end));
        $end = $end.' 23:59';

        $citas = Citas::
        whereDate('fecha','>=',$start)
        ->whereDate('fecha','<=',$end)
        ->orderBy('fecha')
        ->get();
        $salida_cron = [];
        foreach ($citas as $key => $cita) {

            $description = '<b>Especialidad: </b>'.$cita->especialidades->nombre.'<br>';
            $description .= '<b>Paciente: </b>'.userFullName($cita->user_id).'<br>';
            $description .= '<b>Estado: </b><b style="color:'.$cita->getColor().'">'.$cita->getEstado(0).'</b><br>';

            $salida_cron[$key]['id'] = code($cita->id);
            $salida_cron[$key]['calendarId'] = '1';
            $salida_cron[$key]['title'] =  date("H:i", strtotime($cita->fecha)).' - '.$cita->cod;
            $salida_cron[$key]['category'] = 'allday';
            $salida_cron[$key]['body'] = $description;
            $salida_cron[$key]['location'] = date("d/m/Y H:i", strtotime($cita->fecha));
            $salida_cron[$key]['start'] = date("Y-m-d H:i", strtotime($cita->fecha));
            $salida_cron[$key]['color'] = '#FFFFFF';
            $salida_cron[$key]['bgColor'] = $cita->getColor();
            $salida_cron[$key]['borderColor'] = $cita->getColor();
        }
        return $salida_cron;

    }
}
