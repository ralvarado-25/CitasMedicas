<?php

namespace App\Http\Controllers;

use App\Citas;
use App\Especialidades;
use App\Mail\NuevoUsuario;
use Illuminate\Http\Request;
use App\User;
use Session;
use DB;
use PDF;
use Mail;

class CitasController extends Controller
{
    public function index (Request $request){
        $citas = Citas::orderBy('cod','desc')->get();
        $especialidades = Especialidades::where('activo',1)->get();
        $usuarios = User::where('active',1)->orderBy('ap_paterno')->get();
        Session::put('item', '1.');
        return view("adminTemplate.citas.index", compact('citas','especialidades','usuarios'));
    }

    /**
     * FUncion para guardar registro
     */
    public function store(Request $request){

        $hora = (strlen($request->hora) == 4) ? '0'.$request->hora : $request->hora;
        $request->merge(array('hora' => $hora));

        $messages = [
            'fileEspecialidades.mimes' => 'El archivo debe estar en algunos de los siguientes formatos:<br><p class="text-center"><b>gif, jpg, jpeg, png</b></p>',
            'fileEspecialidades.max' => "El archivo a subir es muy grande. El tamaño máximo admitido es de 5 MB (5192 KB).",
        ];
        $validateArray = [
            'paciente' => 'required',
            'especialidad' => 'required',
            'fecha' => 'required|date_format:d/m/Y',
            'hora' => 'required|date_format:H:i',
            'descripcion' => 'nullable|min:2|max:255',
        ];
        $fechasCitas = Citas::select('fecha')
        // ->where('estado','1')
        ->get()->pluck('fecha')->toArray();


        $request->validate([
            'fechahora' => [function ($attribute, $value, $fail) {
                $fechaHora = explode(" ",$value);
                $hora = isset($fechaHora[1]) ? " ".$fechaHora[1].':00' : '';
                $fechaHora = convFechaDT($fechaHora[0]).$hora;
                $fechasCitas = Citas::select('fecha')->where('estado','1')->get()->pluck('fecha')->toArray();
                if(in_array($fechaHora,$fechasCitas)){
                    return $fail(__('La fecha y hora registradas ya se encuentran ocupadas.'));
                }
            }],
            'paciente' => 'required',
            'especialidad' => 'required',
            'fecha' => 'required|date_format:d/m/Y',
            'hora' => 'required|date_format:H:i',
            'descripcion' => 'nullable|min:2|max:255',
        ],$messages);

        $request->validate($validateArray, $messages);
        dd(3123123);

        $reg_maximo = Citas::select('cod')->where('cod', 'LIKE', "%CI%")->max('cod');
        $cod = generateCode($reg_maximo,'CI000001','CI',2,6);
        DB::beginTransaction();
        try {
            $cita = new Citas();
            $cita->user_id = $request->paciente;
            $cita->cod = $cod;
            $cita->especialidad_id = $request->especialidad;
            $cita->fecha = convFechaDT($request->fecha).' '.$request->hora;
            $cita->descripcion = $request->descripcion;
            $cita->estado = "0";
            $cita->save();
            toastr()->success('Registrada con éxito.','Cita '.$cita->cod, ['positionClass' => 'toast-bottom-right']);
            DB::commit();
            return  \Response::json(['success' => '1']);
        }catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        toastr()->success('Registrado con éxito.','Ejemplo ', ['positionClass' => 'toast-bottom-right']);
        return back();
    }


    /**
     * FUncion para actualizar registro
     */
    public function update(Request $request, $id){
        toastr()->info('Modificado con éxito.','Ejemplo ', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    /**
     * FUncion para eliminar registro
     */
    public function destroy($id){
        toastr()->error('Eliminado correctamente.','Ejemplo ', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    function cambiarEstado($id,$estado){
        return back();
    }

    /**
     * FUncion para exportar PDF
     */
    public function exportPdf(Request $request){

    }

    public function enviarMail(){

        return back();
    }
}
