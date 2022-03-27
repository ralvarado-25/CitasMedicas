<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\NuevoUsuario;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Session;
use Auth;
use Mail;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Storage;
use Cookie;
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

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit($id){
        $user=User::findOrFail(decode($id));
        if($user->active == '1'){
            $roles = Role::where('active','1')->get();
            Session::put('item', '2.');
            return view('adminTemplate.users.edit',compact('user','roles'));
        }
        abort(404);
    }

    /**
     * Actualiza los datos de un usuario.
     *
     */
    public function update(Request $request, $id){
        $user = User::where('id',decode($id))->first();
        // Validacion por request
        $messages = [
            'name.required' => 'El campo Nombre(s) es obligatorio',
            'name.min' => 'El campo Nombre(s) debe tener como mínimo 2 caracteres',
            'name.max' => 'El campo Nombre(s) debe tener como máximo 40 caracteres',
            'ap_paterno.required' => 'El campo Apellido Paterno es obligatorio',
            'ap_paterno.min' => 'El campo Apellido Paterno debe tener como mínimo 2 caracteres',
            'ap_paterno.max' => 'El campo Apellido Paterno debe tener como máximo 50 caracteres',
            'ap_materno.min' => 'El campo Apellido Materno debe tener como mínimo 2 caracteres',
            'ap_materno.max' => 'El campo Apellido Materno debe tener como máximo 50 caracteres',
            'cargo.min' => 'El campo Cargo debe tener como mínimo 2 caracteres',
            'cargo.max' => 'El campo Cargo debe tener como máximo 100 caracteres',
            'nro_doc.required' => 'El campo Nº de documento es obligatorio.',
            'fecha_nac.date_format'  => 'El campo Fecha de Nacimiento no corresponde a una fecha válida',

            // MENSAJES PASSWORD
            'password_first.min'  => 'El campo Contraseña Nueva debe contener al menos 8 caracteres.',
            'password_first.required'  => 'El campo Contraseña Nueva" es obligatorio',
            'password_first.regex'  => 'El campo Contraseña Nueva" NO CUMPLE CON LOS REQUERIMIENTOS',
            'new_password.min'  => 'El campo Confirmar Contraseña Nueva debe contener al menos 8 caracteres.',
            'new_password.required'  => 'El campo Confirmar Contraseña Nueva es obligatorio',
            'new_password.regex'  => 'El campo Confirmar Contraseña Nueva NO CUMPLE CON LOS REQUERIMIENTOS',
            'new_password.same' => 'Los campos "Contraseña nueva" y "Confirmar contraseña nueva" deben coincidir.'
        ];

        $validateArray = [
            'username' => 'bail|required|max:45|min:5|regex:/^[A-Za-z0-9ñáéíóúÁÉÍÓÚÑ@#$%^&*+:;,. -]+$/|unique:users,username,'.$user->id,
            'name' => 'bail|required|max:40|min:2',
            'ap_paterno' => 'bail|required|max:50|min:2',
            'ap_materno' => 'bail|nullable|max:50|min:2',
            'cargo'=>'min:2|max:100',
            'email' => 'bail|required|email:filter',
            'celular'=>'min:3|max:20',
            'nro_doc' => 'required',
        ];

        $validatePassword = [
            'password_first' => 'bail|required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'new_password' => 'bail|required|min:8|same:password_first|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ];
        if($request->auxpass == 1 ){
            $validateArray = array_merge($validateArray,$validatePassword);
        }
        $request->validate($validateArray,$messages);

        DB::beginTransaction();
        try {
            // PRINCIPALES
            $user->username=$request->username;
            $user->name=$request->name;
            $user->ap_paterno=$request->ap_paterno;
            $user->ap_materno=$request->ap_materno;
            $user->cargo=$request->cargo;
            $user->email=$request->email;
            $user->celular=$request->celular;
            $user->fecha_nacimiento = ($request->fecha_nac != null) ? convFechaDT($request->fecha_nac) : null;
            $user->nro_doc = $request->nro_doc;

            // PASSWORD
            if($request->auxpass == 1 && $request->password_first != null && $request->new_password != null ){
                $user->password = bcrypt($request->new_password);
                toastr()->success('Modificada con éxito.','Contraseña '.userFullName($user->id), ['positionClass' => 'toast-bottom-right']);
            }
            $user->update();
            toastr()->info('Modificado con éxito.','Usuario '.userFullName($user->id), ['positionClass' => 'toast-bottom-right']);
            DB::commit();
            return  \Response::json(['success' => '1']);
        } //termina el try
        catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function uploadAvatarImagen(Request $request){
        $image_parts = explode(";base64,", $request->image);
        $file = base64_decode($image_parts[1]);
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $file);
        $tmpFile = new File($tmpFilePath);
        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,true // Mark it as test, since the file isn't from real HTTP POST.
        );
        $user = User::where('id',decode($request->userid))->first();
        if(isset($user->avatar)){
            $ruta='public/general/avatar/'.$user->avatar;
            $ruta_thum='public/general/avatar/thumbnail/'.$user->avatar;
            // Si la imagen es la imagen por defecto no se la eliminara
            if ($user->avatar!='avatar0.png' && Storage::exists($ruta))         Storage::delete($ruta);
            if ($user->avatar!='avatar0.png' && Storage::exists($ruta_thum))    Storage::delete($ruta_thum);
        }
        $name = base64_encode($user->id).'_'.$this->generarCodigoImg(6).'.png';
        $file->storeAs("public/general/avatar/", $name);
        $file->storeAs("public/general/avatar/thumbnail/", $name);

        InterventionImage::make($file)->resize(250,250, function ($constraint){
            $constraint->aspectRatio();
        })->save(storage_path().'/app/public/general/avatar/thumbnail/'.$name,90);

        $user->avatar = $name;
        $user->update();
        toastr()->info('Modificado con éxito','Avatar ', ['positionClass' => 'toast-bottom-right']);
        return response()->json(['success'=>'1']);
    }

    public function generarCodigoImg($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
        return $key;
    }

    /**
     * Actualiza el rol de un usuario.
     */
    public function updaterol(Request $request, $id){
        $user=User::findOrFail($id);
        DB::beginTransaction();
        try {
            $roleU = $request->get('roles');
            $permiso = User::from('users as u')->join('roles as r','u.role_id','r.id')
            ->select('u.role_id','r.id', 'r.name', 'r.guard_name')
            ->where('r.active','1')->first();
            if($permiso->id==$roleU){
                $user->role_id=1;
                $user->update();
            }else{
                $user->role_id=$roleU;
                $user->update();
            }
            $user->syncRoles($roleU);
            $per = User::join('model_has_roles','model_has_roles.model_id','=','users.id')
            ->join('role_has_permissions','role_has_permissions.role_id','=','model_has_roles.role_id')
            ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
            ->select('role_has_permissions.permission_id')
            ->where('users.id',$user->id)->get();
            $x = $per->count();
            /* SINCONIZANDO PERMISOS A USUARIOS */
            $ar = [];
            for($i=0; $i<$x ; $i++){
                $y=$per[$i]->permission_id;
                array_push($ar,$y);
            }
            $user->permissions()->sync($ar);
            $user->removeRole($roleU);
            DB::commit();
            toastr()->info('Realizado con éxito.','Asignación de nuevo rol ', ['positionClass' => 'toast-bottom-right']);
        }catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return back();
    }

    /**
     * Muestra el formulario para que el usuario conectado cambie sus datos.
     */
    public function perfil(){
        Session::put('item', '2.');
        return view('adminTemplate.users.perfil');
    }

    /**
     * Actualiza el perfil del usuario conectado.
     */
    public function updateProfile(Request $request, $id){
        $messages = [
            'name.required'  => 'El campo Nombre(s) es obligatorio',
            'name.max'  => 'El campo Nombre(s) debe tener al menos 2 caracteres',
            'name.min'  => 'El campo Nombre(s) no debe tener más de 50 caracteres',
            'ap_paterno.required'  => 'El campo Apellido Paterno es obligatorio',
            'ap_paterno.min'  => 'El campo Apellido Paterno debe tener al menos 2 caracteres',
            'ap_paterno.max'  => 'El campo Apellido Paterno no debe tener más de 50 caracteres',
            'fechanac.date_format'  => 'El campo Fecha de Nacimiento no corresponde a una fecha válida',
            'nrodoc.required' => 'El campo Documento de identidad es obligatorio',
            'current_password.required'  => 'EL CAMPO "Contraseña Actual" ES OBLIGATORIO',
            'password_first.min'  => 'El campo Contraseña Nueva debe contener al menos 8 caracteres.',
            'password_first.required'  => 'EL CAMPO "Contraseña Nueva" ES OBLIGATORIO',
            'password_first.regex'  => 'EL CAMPO "Contraseña Nueva" NO CUMPLE CON LOS REQUERIMIENTOS',
            'password_first.required_with' => 'El campo contraseña nueva es obligatorio cuando Contraseña actual está presente.',
            'new_password.min'  => 'El campo Confirmar Contraseña Nueva debe contener al menos 8 caracteres.',
            'new_password.required'  => 'EL CAMPO "Confirmar Contraseña Nueva" ES OBLIGATORIO',
            'new_password.regex'  => 'EL CAMPO "Confirmar Contraseña Nueva" NO CUMPLE CON LOS REQUERIMIENTOS',
            'new_password.same' => 'Los campos "Contraseña nueva" y "Confirmar contraseña nueva" deben ser iguales',
            'new_password.same' => 'Los campos "Contraseña nueva" y "Confirmar contraseña nueva" deben ser iguales',
        ];

        $validateArray = [
            'name' => 'required|max:40|min:2',
            'ap_paterno' => 'required|max:50|min:2',
            'ap_materno' => 'nullable|max:50|min:2',
            'fechanac' =>'nullable|date_format:d/m/Y',
            'email' => 'required|email:filter',
            'nrodoc' => 'required',
            'celular' => 'max:20|min:3',
        ];

        if($request->auxpass == 1 ){
            $request->validate([
                'current_password' => ['required', function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, Auth::user()->password)) {
                        return $fail(__('La contraseña ingresada no coincide con la almacenada en el sistema.'));
                    }
                }],
                'password_first' => 'bail|required_with:current_password|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'new_password' => 'bail|required_with:password_first|min:8|same:password_first|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'name' => 'bail|required|max:40|min:2',
                'ap_paterno' => 'bail|required|max:50|min:2',
                'ap_materno' => 'bail|nullable|max:50|min:2',
                'fechanac' =>'nullable|date_format:d/m/Y',
                'email' => 'required|email:filter',
                'nrodoc' => 'bail|required',
                'celular' => 'max:20|min:3',

            ],$messages);
            toastr()->success('modificada con éxito.','Contraseña', ['positionClass' => 'toast-bottom-right',]);

        }else   $request->validate($validateArray,$messages);


        $user = User::findOrFail(decode($id));
            if($request->auxpass == 1 && $request->current_password != null && $request->password_first != null && $request->new_password != null){
                $user->password = bcrypt($request->new_password);
                if(Cookie::has('login2')){
                    Cookie::queue(Cookie::forget('login2'));
                }
            }
            $user->name = $request->name;
            $user->ap_paterno = $request->ap_paterno;
            $user->ap_materno = $request->ap_materno;
            $user->fecha_nacimiento = $request->fechanac != null ? convFechaDT($request->fechanac) : null;
            $user->email = $request->email;
            $user->cargo = $request->cargo;
            $user->nro_doc = $request->nrodoc;
            $user->celular = $request->celular;
            $user->update();
        toastr()->info('modificados con éxito.','Datos de perfil ', ['positionClass' => 'toast-bottom-right',]);
        return  \Response::json(['success' => '1']);
    }

    /**
     * Carga la ventana de confirmacion para
     */
    public function modalCambioEstado($id){
        $users = User::findOrFail(decode($id));
        return view('adminTemplate.users.modalCambioEstado', compact('users'));
    }

    public function cambiarestado($id){
        $user=User::findOrFail(decode($id));
        if($user->id != userId()){
            if ($user->active=='0') {
                $user->active='1';
                toastr()->info('Activado correctamente.','Usuario '.userFullName($user->id), ['positionClass' => 'toast-bottom-right']);
            }else {
                $user->active='0';
                toastr()->warning('Desactivado correctamente.','Usuario '.userFullName($user->id), ['positionClass' => 'toast-bottom-right']);
            }
            $user->update();
        }
        return back();
    }

        /**
     * Carga el formulario para eliminar los datos de la asignación del grupo de correos a un módulo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modalDelete($id){
        $users = User::findOrFail(decode($id));
        return view('adminTemplate.users.modalDelete', compact('users'));
    }

    /**
     * Elimina un usuario dado.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        $user = User::findOrFail(decode($id));
        $messages = [
            'userborrar.required' => 'El campo es obligatorio',
            'userborrar.in' => 'El campo no coincide con <b>'.$user->username.'</b>',
        ];
        $validateRetiro = [
            'userborrar' => 'bail|required|in:'.$user->username,
        ];
        $request->validate($validateRetiro,$messages);

        if($user->id != userId()){
            if(isset($user->avatar)){
                $ruta = 'public/general/avatar/'.$user->avatar;
                $ruta_thum = 'public/general/avatar/thumbnail/'.$user->avatar;
                if ($user->avatar!='avatar0.png' && Storage::exists($ruta))         Storage::delete($ruta);
                if ($user->avatar!='avatar0.png' && Storage::exists($ruta_thum))    Storage::delete($ruta_thum);
            }
            if(isset($user->firma)){
                $ruta = "public/empresas_archivos/".miEmpresa()->cod.'/firmas/'.$user->firma;
                if (Storage::exists($ruta)) Storage::delete($ruta);
            }
            $user->active = 2;
            $user->update();
            $user->permissions()->sync([]);
            toastr()->error('Eliminado correctamente.','Usuario '.userFullName($user->id), ['positionClass' => 'toast-bottom-right']);
        }
        return  \Response::json(['success' => '1']);
    }


    // ==============================================================================================================================
    //                                                VALIDACIONES LARAVEL
    // ==============================================================================================================================
    public function validateUpdateUser($request, $user){
        $messages = [
            'name.required' => 'El campo Nombre(s) es obligatorio',
            'name.min' => 'El campo Nombre(s) debe tener como mínimo 2 caracteres',
            'name.max' => 'El campo Nombre(s) debe tener como máximo 40 caracteres',
            'ap_paterno.required' => 'El campo Apellido Paterno es obligatorio',
            'ap_paterno.min' => 'El campo Apellido Paterno debe tener como mínimo 2 caracteres',
            'ap_paterno.max' => 'El campo Apellido Paterno debe tener como máximo 50 caracteres',
            'ap_materno.min' => 'El campo Apellido Materno debe tener como mínimo 2 caracteres',
            'ap_materno.max' => 'El campo Apellido Materno debe tener como máximo 50 caracteres',
            'cargo.min' => 'El campo Cargo debe tener como mínimo 2 caracteres',
            'cargo.max' => 'El campo Cargo debe tener como máximo 100 caracteres',
            'nro_doc.required' => 'El campo Nº de documento es obligatorio.',
            'fecha_nac.date_format'  => 'El campo Fecha de Nacimiento no corresponde a una fecha válida',

            // MENSAJES PASSWORD
            'password_first.min'  => 'El campo Contraseña Nueva debe contener al menos 8 caracteres.',
            'password_first.required'  => 'El campo Contraseña Nueva" es obligatorio',
            'password_first.regex'  => 'El campo Contraseña Nueva" NO CUMPLE CON LOS REQUERIMIENTOS',
            'new_password.min'  => 'El campo Confirmar Contraseña Nueva debe contener al menos 8 caracteres.',
            'new_password.required'  => 'El campo Confirmar Contraseña Nueva es obligatorio',
            'new_password.regex'  => 'El campo Confirmar Contraseña Nueva NO CUMPLE CON LOS REQUERIMIENTOS',
            'new_password.same' => 'Los campos "Contraseña nueva" y "Confirmar contraseña nueva" deben coincidir.'
        ];

        $validateArray = [
            'username' => 'bail|required|max:45|min:5|regex:/^[A-Za-z0-9ñáéíóúÁÉÍÓÚÑ@#$%^&*+:;,. -]+$/|unique:users,username,'.$user->id,
            'name' => 'bail|required|max:40|min:2',
            'ap_paterno' => 'bail|required|max:50|min:2',
            'ap_materno' => 'bail|nullable|max:50|min:2',
            'cargo'=>'min:2|max:100',
            'email' => 'bail|required|email:filter',
            'celular'=>'min:3|max:20',
            'nro_doc' => 'required',
        ];

        $validatePassword = [
            'password_first' => 'bail|required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'new_password' => 'bail|required|min:8|same:password_first|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ];
        if($request->auxpass == 1 ){
            $validateArray = array_merge($validateArray,$validatePassword);
        }
        return $request->validate($validateArray,$messages);
    }
}
