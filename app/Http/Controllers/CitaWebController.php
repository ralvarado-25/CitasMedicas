<?php

namespace App\Http\Controllers;

use App\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaWebController extends Controller
{
        /**
     * FUncion para guardar registro
     */
    public function store(Request $request){

        $hora = (strlen($request->hour) == 4) ? '0'.$request->hour : $request->hour;
        $request->merge(array('hour' => $hora));


        $messages = [
            'fileEspecialidades.mimes' => 'El archivo debe estar en algunos de los siguientes formatos:<br><p class="text-center"><b>gif, jpg, jpeg, png</b></p>',
            'fileEspecialidades.max' => "El archivo a subir es muy grande. El tamaño máximo admitido es de 5 MB (5192 KB).",
        ];
        $validateArray = [
            'name' => 'required',
            'email' => 'required|email:filter',
            'phone' => 'required',
            'especialidad' => 'required',
            'date' => 'required|date_format:d/m/Y',
            'hour' => 'required|date_format:H:i',
            'message' => 'nullable|min:2|max:255',
        ];

        $request->validate($validateArray, $messages);

        $reg_maximo = Citas::select('cod')->where('cod', 'LIKE', "%CI%")->max('cod');
        $cod = generateCode($reg_maximo,'CI000001','CI',2,6);
        DB::beginTransaction();
        try {
            $info = "<b>Solicitud desde pagina web por: </b>".$request->name;
            $info .= "<br><b>Télefono: ".$request->phone.'</b>';
            $info .= "<br>".$request->message;
            $cita = new Citas();
            $cita->user_id = 1;
            $cita->cod = $cod;
            $cita->especialidad_id = $request->especialidad;
            $cita->fecha = convFechaDT($request->date).' '.$request->hour;
            $cita->descripcion = $info;
            $cita->estado = "0";
            $cita->origen = $request->email;
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

}
