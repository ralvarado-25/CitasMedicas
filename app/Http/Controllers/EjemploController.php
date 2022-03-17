<?php

namespace App\Http\Controllers;

use App\Ejemplo;
use App\Mail\NuevoUsuario;
use Illuminate\Http\Request;
use App\User;
use Session;
use PDF;
use Mail;
class EjemploController extends Controller
{
    public function index (Request $request){
        $filtro = 'ejemplo de variable';

        $listaEjemplos = Ejemplo::orderBy('cod','desc')->get();
        $listaUsuarios = User::where('active','1')->get();
        Session::put('item', '2.');
        return view("adminTemplate.ejemplo.index", compact('listaEjemplos','listaUsuarios'));
    }

    /**
     * FUncion para guardar registro
     */
    public function store(Request $request){
        // Generar codigo de registro automatico $cod
        // Se pone las dos primeras letras segun lo requerido  en este caso MP
        $reg_maximo = Ejemplo::select('cod')->where('cod', 'LIKE', "%MP%")->max('cod');
        $cod = generateCode($reg_maximo,'MP000001','MP',2,6);

        // Se crea un objeto con el modelo para la variable ejemplo
        // y se va guardando los datos del request en cada columna de la tabla
        $ejemplo = new Ejemplo();
        $ejemplo->user_id = $request->usuario;
        $ejemplo->cod = $cod;
        $ejemplo->start_date = convFechaDT($request->fecha_ini);
        $ejemplo->end_date = convFechaDT($request->fecha_fin);
        $ejemplo->description = $request->descripcion;
        $ejemplo->state = 1;
        $ejemplo->save(); // Con save() se guarda todo en la BD

        toastr()->success('Registrado con éxito.','Ejemplo '.$cod, ['positionClass' => 'toast-bottom-right']);
        return back();
    }


    /**
     * FUncion para actualizar registro
     */
    public function update(Request $request, $id){
        // Se obtiene el registro que se va a modificar con la variable $id
        $ejemplo = Ejemplo::findOrFail(decode($id));
        // $ejemplo = Ejemplo::where('id',decode($id))->first();

        // y se va guardando los datos del request en cada columna de la tabla
        $ejemplo->user_id = $request->usuarioedit;
        $ejemplo->start_date = convFechaDT($request->fecha_iniedit);
        $ejemplo->end_date = convFechaDT($request->fecha_finedit);
        $ejemplo->description = $request->descripcionedit;
        $ejemplo->update(); // Con update() se actualizado el registro en la BD
        toastr()->info('Modificado con éxito.','Ejemplo '.$ejemplo->cod, ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    /**
     * FUncion para eliminar registro
     */
    public function destroy($id){
        // Se obtiene el registro que se va a modificar con la variable $id
        $ejemplo = Ejemplo::findOrFail(decode($id));
        $ejemplo->delete();
        toastr()->error('Eliminado correctamente.','Ejemplo '.$ejemplo->cod, ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    function cambiarEstado($id,$estado){
        $ejemplo = Ejemplo::findOrFail(decode($id));
        $ejemplo->state = $estado == 1 ? 0 : 1;
        $ejemplo->update();

        if($estado == 1){
            toastr()->error('Desactivado.','Registro '.$ejemplo->cod, ['positionClass' => 'toast-bottom-right']);
        }else{
            toastr()->info('Activado.','Registro '.$ejemplo->cod, ['positionClass' => 'toast-bottom-right']);
        }
        return back();
    }

    /**
     * FUncion para exportar PDF
     */
    public function exportPdf(Request $request){
        // Obtener lista de datos de la tabla ejemplo en la BD
        $listaEjemplos = Ejemplo::orderBy('cod','desc')->get();
        // Cargar la vista que sera mostrada en el pdf
        $pdf = PDF::loadView("adminTemplate.ejemplo.pdf", compact('listaEjemplos'));

        // Geberar el PDF
        return $pdf->setOption('margin-bottom',8)->setOption('margin-top',7)
        ->setPaper('A4', 'landscape') // portrait
        ->setOption('footer-right', 'Pagina [page] de [toPage] ')
        ->setOption('footer-left', 'Exportado el '. date('d/m/Y') .' a la(s) '.date('H:i'))
        ->stream('PDF_Dentalife.pdf');
    }

    public function enviarMail(){
        $user = User::findOrFail(userId());
        $password = 'passw0rdEjemp1o';
        $mailAdds = ['user1@mail.com','user2@mail.com'];
        $mailto = userMail(userId());
        Mail::to($mailto)->cc($mailAdds)->send(new NuevoUsuario($user, $password));
        toastr()->warning('enviado correctamente.','Mail', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    public function plantillaMail(){
        $user = User::findOrFail(userId());
        $pass = 'passw0rdEjemp1o';
        return view("adminTemplate.mails.plantillaMail", compact('user','pass'));
    }
}
