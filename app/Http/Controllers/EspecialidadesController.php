<?php

namespace App\Http\Controllers;

use App\Especialidades;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;
class EspecialidadesController extends Controller
{
    public function index (Request $request){
        $especialidades = Especialidades::where('activo',1)->get();
        Session::put('item', '4.');
        return view("adminTemplate.especialidades.index", compact('especialidades'));
    }

    /**
     * Muestra ventana con los detalles de la especialidad
     */
    public function show(Request $request, $id){
        $esp = Especialidades::findOrFail(decode($id));
        return view("adminTemplate.especialidades.modalShow", compact('esp'));
    }

    /**
     * FUncion para guardar especialidad
     */
    public function store(Request $request){
        $messages = [
            'fileEspecialidades.mimes' => 'El archivo debe estar en algunos de los siguientes formatos:<br><p class="text-center"><b>gif, jpg, jpeg, png</b></p>',
            'fileEspecialidades.max' => "El archivo a subir es muy grande. El tamaño máximo admitido es de 5 MB (5192 KB).",
        ];
        $validateArray = [
            'nombre' => 'required',
            'duracion' => 'required|numeric',
            'descripcion' => 'required|min:2|max:255',
            'fileEspecialidades' => 'bail|nullable|mimes:gif,jpg,jpeg,png|max:5192',
        ];
        $request->validate($validateArray, $messages);

        $reg_maximo = Especialidades::select('cod')->where('cod', 'LIKE', "%ES%")->max('cod');
        $cod = generateCode($reg_maximo,'ES000001','ES',2,6);
        DB::beginTransaction();
        try {
            $especialidad = new Especialidades();
            $especialidad->user_id = userId();
            $especialidad->cod = $cod;
            $especialidad->nombre = $request->nombre;
            $especialidad->descripcion = $request->descripcion;
            $especialidad->duracion = $request->duracion;
            $especialidad->activo = "1";
            if ( $request->hasFile('fileEspecialidades') ){
                $archivo = $request->file('fileEspecialidades');
                $nombreConExtension = $archivo->getClientOriginalName();
                $nombreConExtension = delete_charspecial($nombreConExtension);
                $especialidad->imagen = $cod . '_' . strtolower($nombreConExtension);
                $archivo->storeAs("public/especialidad/", $especialidad->imagen);
                $size = getimagesize($archivo);
                if($size[0]<=1024 && $size[1]<=1024){
                    InterventionImage::make($archivo)->resize(function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/especialidad/'.$especialidad->imagen, 90);
                }else{
                    InterventionImage::make($archivo)->resize(1024,1024, function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/especialidad/'.$especialidad->imagen, 80);
                }
            }
            $especialidad->save();
            toastr()->success('Registrado con éxito.','Especialidad '.$especialidad->nombre, ['positionClass' => 'toast-bottom-right']);
            DB::commit();
            return  \Response::json(['success' => '1']);
        }catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Muestra ventana para la edicion de especialidad
     */
    public function modalEdit (Request $request, $id){
        $esp = Especialidades::findOrFail(decode($id));
        return view("adminTemplate.especialidades.modalEdit", compact('esp'));
    }
    /**
     * FUncion para actualizar registro
     */
    public function update(Request $request, $id){
        $messages = [
            'nombreedit.required' => 'El campo nombre es obligatorio',
            'duracionedit.required' => 'El campo duracion es obligatorio',
            'duracionedit.numeric' => 'El campo duracion debe ser un número',
            'descripcionedit.required' => 'El campo descripcion es obligatorio',
            'descripcionedit.min' => 'El campo descripcion debe tener al menos 2 caracteres',
            'descripcionedit.max' => 'El campo descripcion no debe tener mas de 255 caracteres',
            'fileEspecialidadesEdit.mimes' => 'El archivo debe estar en algunos de los siguientes formatos:<br><p class="text-center"><b>gif, jpg, jpeg, png</b></p>',
            'fileEspecialidadesEdit.max' => "El archivo a subir es muy grande. El tamaño máximo admitido es de 5 MB (5192 KB).",
            'fileEspecialidadesEdit.required' => "Debe subir una imagen.",
        ];
        $validateArray = [
            'nombreedit' => 'required',
            'duracionedit' => 'required|numeric',
            'descripcionedit' => 'required|min:2|max:255',
        ];
        $valFile = ['fileEspecialidadesEdit' => 'required|mimes:gif,jpg,jpeg,png|max:5192'];
        if($request->cambioarchivo == 1 ) $validateArray = array_merge($validateArray,$valFile);
        $request->validate($validateArray, $messages);

        $especialidad = Especialidades::findOrFail(decode($id));

        if ( $request->hasFile('fileEspecialidadesEdit') ){
            $rutaFile = "public/especialidad/".$especialidad->imagen;
            if (Storage::exists($rutaFile)) Storage::delete($rutaFile);

            $archivo = $request->file('fileEspecialidadesEdit');
            $nombreConExtension = $archivo->getClientOriginalName();
            $nombreConExtension = delete_charspecial($nombreConExtension);
            $especialidad->imagen = $especialidad->cod . '_' . strtolower($nombreConExtension);
            $archivo->storeAs("public/especialidad/", $especialidad->imagen);
            $size = getimagesize($archivo);
            if($size[0]<=1024 && $size[1]<=1024){
                InterventionImage::make($archivo)->resize(function ($constraint){
                    $constraint->aspectRatio();
                })->save(storage_path().'/app/public/especialidad/'.$especialidad->imagen, 90);
            }else{
                InterventionImage::make($archivo)->resize(1024,1024, function ($constraint){
                    $constraint->aspectRatio();
                })->save(storage_path().'/app/public/especialidad/'.$especialidad->imagen, 80);
            }
        }

        $especialidad->nombre = $request->nombreedit;
        $especialidad->descripcion = $request->descripcionedit;
        $especialidad->duracion = $request->duracionedit;
        $especialidad->update();

        toastr()->info('Modificada con éxito.','Especialidad '.$especialidad->nombre, ['positionClass' => 'toast-bottom-right']);
        return  \Response::json(['success' => '1']);
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
