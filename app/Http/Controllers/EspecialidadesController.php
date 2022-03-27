<?php

namespace App\Http\Controllers;

use App\Especialidades;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as InterventionImage;
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
