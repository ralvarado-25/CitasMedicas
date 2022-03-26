<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\NuevoUsuario;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Session;
use PDF;
use Mail;
use DB;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index (Request $request){

        $userlog = User::where('id',userId())->get();
        $usersa = User::where('active',1)->where('id','!=',userId())->orderBy('ap_paterno','asc')->get();
        $usersi = User::where('active','!=',2)->where('active','!=',1)->orderBy('ap_paterno','asc')->get();
        $usersa = $userlog->merge($usersa);
        $usersa = $usersa->merge($usersi);

        $usersactive = User::where('active',1)->count();
        $usersinactive = User::where('active',0)->count();
        $usersdelete = User::where('active',2)->count();

        $filtro = 'ejemplo de variable';
        Session::put('item', '2.');
        return view("adminTemplate.users.index", compact('usersactive','usersinactive','usersdelete','usersa','usersi'));
    }

    /**
     * Muestra los detalles de un usuario en específico
     */
    public function show( Request $request, $cod){
        $user = User::findOrFail(decode($cod));
        if($user->active == '1'){
            $rol = Role::select('name')->where('id',$user->role_id)->first();
            Session::put('item', '2.');
            return view('adminTemplate.users.show',compact('user','rol'));
        }else   abort(404);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     */
    public function create(){
        $roles = Role::where('active','1')->get();
        Session::put('item', '2.');
        return view('adminTemplate.users.create',compact('roles'));
    }

    /**
    * Funcion para guardar el usuario
    */
    public function store(Request $request) {

        $inicioAnioActual = date('Y').'-01-01';
        $fechaLimite = date('Y-m-d',strtotime ('-9 year' , strtotime($inicioAnioActual)));
        $fechaLimite = date('d/m/Y',strtotime ('-1 day' , strtotime($fechaLimite)));
        $fechaInicial = date('d/m/Y',strtotime ('-90 year' , strtotime($inicioAnioActual)));

        $messages = [
            'username.required' => 'El nombre de usuario es requerido.',
            'username.min' => 'El nombre de usuario debe tener como mínimo 5 caracteres.',
            'username.max' => 'El nombre de usuario debe tener como máximo 45 caracteres.',
            'username.unique' => 'El nombre de usuario debe ser unico.',
            'nro_doc.required' => 'El campo Nº de documento es obligatorio',
            'name.required' => 'El campo Nombre(s) es obligatorio',
            'name.min' => 'El campo Nombre(s) debe tener como mínimo 2 caracteres',
            'name.max' => 'El campo Nombre(s) debe tener como máximo 40 caracteres',
            'ap_paterno.required' => 'El campo Apellido Paterno es obligatorio',
            'ap_paterno.min' => 'El campo Apellido Paterno debe tener como mínimo 2 caracteres',
            'ap_paterno.max' => 'El campo Apellido Paterno debe tener como máximo 50 caracteres',
            'ap_materno.min' => 'El campo Apellido Materno debe tener como mínimo 2 caracteres',
            'ap_materno.max' => 'El campo Apellido Materno debe tener como máximo 50 caracteres',
            'cargo.max' => 'El campo Cargo debe tener como máximo 100 caracteres',
            'fecha_nac.date_format'  => 'El campo Fecha de Nacimiento no corresponde a una fecha válida',
            'fecha_nac.before_or_equal'  => 'El campo Fecha de Nacimiento debe ser una fecha anterior o igual a '.$fechaLimite,
            'fecha_nac.after_or_equal'  => 'El campo Fecha de Nacimiento debe ser una fecha posterior o igual a '.$fechaInicial,
            'roles.required' => 'Debe escoger una opcion de Rol válida',
        ];
        $validateArray = [
            'username' => 'required|max:45|min:5|unique:users,username',
            'nro_doc' => 'required',
            'name' => 'required|max:40|min:2',
            'ap_paterno' => 'required|max:50|min:2',
            'ap_materno' => 'nullable|max:50|min:2',
            'cargo'=>'required|max:100',
            'email' => 'required|email:filter',
            'fecha_nac' =>'nullable|date_format:d/m/Y',
            'roles' => 'required',
        ];
        $request->validate($validateArray,$messages);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->username = $request->username;
            $user->nro_doc = $request->nro_doc;
            $user->name = $request->name;
            $user->ap_paterno = $request->ap_paterno;
            $user->ap_materno = $request->ap_materno;
            $user->cargo = $request->cargo;
            $user->email = $request->email;
            $user->fecha_nacimiento = $request->fecha_nac != null ? convFechaDT($request->fecha_nac) : null;
            $user->role_id = $request->input('roles');
            $user->password = Hash::make($request->nro_doc);
            $user->save();


            $user->assignRole($request->input('roles'));
            // permisos usuario asignacion
            $per = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            -> join('role_has_permissions', 'role_has_permissions.role_id', '=', 'model_has_roles.role_id')
            -> join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            -> select('role_has_permissions.permission_id')
            -> where('users.id', $user->id)->get();
            $x = $per->count();
            /* SINCONIZANDO PERMISOS A USUARIOS */
            $arpermi = [];
            for ($i = 0; $i < $x; $i++) {
                $y = $per[$i]->permission_id;
                array_push($arpermi, $y);
            }
            $user->permissions()->sync($arpermi);
            $user->removeRole($request->input('roles'));

            // ENVIAR MAIL AL CREAR USUARIO
            $enviarmail = $user->email;
            $mailto = userMail(userId());
            Mail::to($mailto)->cc($enviarmail)->send(new NuevoUsuario($user, $request->nro_doc));


            toastr()->info('Enviados correctamente.','Mails', ['positionClass' => 'toast-bottom-right']);
            toastr()->success('Creado con éxito.','Usuario', ['positionClass' => 'toast-bottom-right']);

            DB::commit();
            return  \Response::json(['success' => '1']);
        }
        catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Funcion para comparar si el nombre de usuario ingresado existe
     */
    public function validarUsername(Request $request){
        if ($request->get('query')) {
            $query = $request->get('query');
            $username=User::where('username',$query)->first();

            if($username==null){
                $msg='
                    <span class="help-block" style="color:#5eba00">
                        <i class="fas fa-check-circle" style="color:#5eba00"></i>&nbsp;El nombre de Usuario está disponible
                    </span><br>
                    <input type="hidden" value="0" id="sw">';
            }else{
                $msg='
                <span class="help-block" style="color:#CD201F">
                    <i class="fas fa-times-circle" style="color:#CD201F"></i>&nbsp;El nombre de Usuario ya está en uso
                </span><br>
                <input type="hidden" value="1" id="sw">';
            }

            return response()->json(array('msg'=> $msg), 200);
        }
    }
}
