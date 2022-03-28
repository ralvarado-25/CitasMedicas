<?php

namespace App\Http\Controllers;

use App\Citas;
use App\Especialidades;
use App\Mail\NuevoUsuario;
use App\Mail\ValidacionCita;
use Illuminate\Http\Request;
use App\User;
use Session;
use DB;
use PDF;
use Illuminate\Support\Facades\Mail;

class CitasController extends Controller
{
    public function index (Request $request){
        $citas = Citas::UserPerm()->orderBy('cod','desc')->get();
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
            $cita->origen = null;
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

    public function modalEdit (Request $request, $id){
        $cita = Citas::findOrFail(decode($id));
        $especialidades = Especialidades::where('activo',1)->get();
        $usuarios = User::where('active',1)->orderBy('ap_paterno')->get();
        return view("adminTemplate.citas.modalEdit", compact('cita','especialidades','usuarios'));
    }
    /**
     * FUncion para actualizar registro
     */
    public function update(Request $request, $id){
        $hora = (strlen($request->horaedit) == 4) ? '0'.$request->horaedit : $request->horaedit;
        $request->merge(array('horaedit' => $hora));

        $messages = [
            'pacienteedit.required' => 'Debe escoger un paciente valido',
            'especialidadedit.required' => 'Debe escoger una opción válida',
            'fechaedit.date_format' => 'El campo fecha debe ser de formato dd/mm/YYYY',
            'fechaedit.required' => 'El campo fecha es obligatorio',
            'horaedit.date_format' => 'El campo hora debe ser de formato HH:mm',
            'horaedit.required' => 'El campo hora es obligatorio',
            'descripcionedit.min' => 'El campo descripcion debe tener al menos 2 caracteres',
            'descripcionedit.max' => 'El campo descripcion no debe tener mas de 255 caracteres',
        ];

        $request->validate([
            'fechahoraedit' => [function ($attribute, $value, $fail) {
                $fechaHora = explode(" ",$value);
                $hora = isset($fechaHora[1]) ? " ".$fechaHora[1].':00' : '';
                $idCita = isset($fechaHora[2]) ? $fechaHora[2] : '';
                $fechaHora = convFechaDT($fechaHora[0]).$hora;
                $cita = Citas::findOrFail(decode($idCita));
                $fechasCitas = Citas::select('fecha')->where('id','!=',$cita->id)->where('estado','1')->get()->pluck('fecha')->toArray();
                if(in_array($fechaHora,$fechasCitas)){
                    return $fail(__('La fecha y hora registradas ya se encuentran ocupadas.'));
                }
            }],
            'pacienteedit' => 'required',
            'especialidadedit' => 'required',
            'fechaedit' => 'required|date_format:d/m/Y',
            'horaedit' => 'required|date_format:H:i',
            'descripcionedit' => 'nullable|min:2|max:255',
        ],$messages);
        $cita = Citas::findOrFail(decode($id));
        $cita->user_id = $request->pacienteedit;
        $cita->especialidad_id = $request->especialidadedit;
        $cita->fecha = convFechaDT($request->fechaedit).' '.$request->horaedit;
        $cita->descripcion = $request->descripcionedit;
        $cita->Update();
        toastr()->info('Modificada con éxito.','Cita '.$cita->cod, ['positionClass' => 'toast-bottom-right']);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete (Request $request, $id){
        $cita = Citas::findOrFail(decode($id));
        return view("adminTemplate.citas.modalDelete", compact('cita'));
    }
    /**
     * FUncion para eliminar registro
     */
    public function destroy($id){
        $cita = Citas::findOrFail(decode($id));
        if($cita->estado != '2'){
            $cita->delete();
            toastr()->error('Eliminada correctamente.','Cita '.$cita->cod, ['positionClass' => 'toast-bottom-right']);
        }
        return back();
    }

    public function modalCambioEstado (Request $request, $id){
        $cita = Citas::findOrFail(decode($id));
        $swdisp = 0;
        return view("adminTemplate.citas.modalEstado", compact('cita','swdisp'));
    }
    function updateState(Request $request,$id){
        $messages = [
            'checkstate.required' => 'Debe escoger una opción válida',
        ];
        $validateArray = [
            'checkstate' =>'required',
        ];
        $validateAnul = [
            'motivo' =>'required',
        ];

        if($request->checkstate == '2') $validateArray = array_merge($validateArray,$validateAnul);
        $request->validate($validateArray, $messages);

        $cita = Citas::findOrFail(decode($id));
        if($cita->estado == 0){
            $cita->estado = $request->checkstate;
            $cita->update();

            if(isset($cita->origen) && $cita->origen != '')
                $mailPaciente = $cita->origen;
            else
                $mailPaciente = userMail($cita->user_id);
            $motivo = $request->motivo;
            Mail::to($mailPaciente)->send(new ValidacionCita($cita, $motivo));
            toastr()->info('Enviado con exito.','Mail de información', ['positionClass' => 'toast-bottom-right']);

            if($cita->estado == "1")
                toastr()->info('Validada con éxito.','Cita '.$cita->cod, ['positionClass' => 'toast-bottom-right']);
            else
                toastr()->error('Anulada correctamente.','Cita '.$cita->cod, ['positionClass' => 'toast-bottom-right']);
        }
        return  \Response::json(['success' => '1']);
    }

    /**
     * FUncion para exportar PDF
     */
    public function exportPdf(Request $request){
        // 'selectFecha','fechainicio','fechafinal','pacientePDF','especialidadPDF'


        $messages = [
            'selectFecha.required' => 'Debe escoger una opción valida',
            'pacientePDF.required' => 'Debe escoger una opción válida',
            'especialidadPDF.required' => 'Debe escoger una opción válida',
            'fechainicio.date_format' => 'El campo fecha de inicio debe ser de formato dd/mm/YYYY',
            'fechainicio.required' => 'El campo fecha de inicio es obligatoria',
            'fechafinal.date_format' => 'El campo fecha final debe ser de formato dd/mm/YYYY',
            'fechafinal.required' => 'El campo fecha final es obligatoria',
            'fechafinal.after' => 'El campo fecha final debe ser posterior a fecha de inicio',
        ];

        $validateArray = [
            'selectFecha' => 'required',
            'pacientePDF' => 'required',
            'especialidadPDF' => 'required',
        ];
        $validateFecha = [
            'fechainicio' => 'required|date_format:d/m/Y',
            'fechafinal' => 'required|date_format:d/m/Y|after:fechainicio',
        ];


        if($request->selectFecha == 'r' ) $validateArray = array_merge($validateArray,$validateFecha);
        $request->validate($validateArray, $messages);

        $inicio = convFechaDT($request->fechainicio).' 00:00:00';
        $final = convFechaDT($request->fechafinal).' 23:59:59';
        $citas = Citas::
        Paciente($request->pacientePDF)
        ->Especialidad($request->especialidadPDF)
        ->RangeDate($inicio, $final, $request->selectFecha)
        ->orderBy('cod','desc')->get();
        // Cargar la vista que sera mostrada en el pdf
        $pdf = PDF::loadView("adminTemplate.citas.pdf", compact('citas'));

        // Geberar el PDF
        return $pdf->setOption('margin-bottom',8)->setOption('margin-top',7)
        ->setPaper('A4', 'portrait') // portrait
        ->setOption('footer-right', 'Pagina [page] de [toPage] ')
        ->setOption('footer-left', 'Exportado el '. date('d/m/Y') .' a la(s) '.date('H:i'))
        ->stream('PDF_Dentalife.pdf');

    }

    public function enviarMail(){

        return back();
    }
}
