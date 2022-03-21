<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\NuevoUsuario;

use Spatie\Permission\Models\Role;
use App\Permission;
use Session;
use PDF;
use Auth;
use Illuminate\Support\Facades\Hash;
class RoleController extends Controller
{
    public function index (Request $request){
        $roles = Role::get();
        Session::put('item', '3.');
        return view("adminTemplate.roles.index", compact('roles'));
    }

    /**
     * Almacena un nuevo rol.
     */
    public function show($id){
        $role = Role::findOrFail(decode($id));
        $permissions = $role->permissions()->where('active',1)->orderBy('parent_id')->get();
        Session::put('item', '3.');
        return view('adminTemplate.roles.show',compact('role', 'permissions'));
    }

    /**
     * Muestra el formulario para crear un rol
     */
    public function create(){
        $roles = Role::where('active','1')->get();
        $permissions_= Permission::where('parent_id',null)->where('active','1')->orderBy('parent_id','DESC')->get();
        Session::put('item', '3.');
        return view('adminTemplate.roles.create',compact('roles','permissions_'));
    }

    /**
     * Almacena un nuevo rol.
     */
    public function store(Request $request){
        $request['permissions'] = ($request->permissions != null)? $request->permissions : [] ;
        $messages = [
            'name.required'  => 'El campo nombre es obligatorio',
            'name.max'  => 'El campo nombre no debe contener más de 190 caracteres',
            'description.required'  => 'El campo descripción es obligatorio',
            'name.max'  => 'El campo descripción no debe contener más de 190 caracteres',
            'permissions.min'  => 'Debe asignar al menos 1 permiso',
        ];
        $validateArray = [
            'name'=>'required|max: 190',
            'description'=>'required|max: 190',
            'permissions' => 'min:1',
        ];
        $request->validate($validateArray,$messages);

        $permisos=$request->get('permissions');
        // SINCONIZANDO PERMISOS A ROLES
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->active = 1;
        $role->save();
        $role->permissions()->sync($permisos);
        toastr()->success('Registrado con éxito.','Rol '.$role->name, ['positionClass' => 'toast-bottom-right']);
        return  \Response::json(['success' => '1']);
    }

    /**
     * Muestra el formulario para editar un rol.
     */
    public function edit($id){
        $role = Role::where('id',decode($id))->first();
        $roles = Role::where('active','1')->get();
        $permissions_ = Permission::where('parent_id',null)->where('active','1')->orderBy('parent_id','DESC')->get();
        Session::put('item', '3.');
        return view('adminTemplate.roles.edit',compact('role','roles','permissions_'));
    }

    /**
     * Funcion para actualizar el rol
     */
    public function update(Request $request, $id){
        $request['permissions'] = ($request->permissions != null)? $request->permissions : [] ;
        $messages = [
            'name.required'  => 'El campo nombre es obligatorio',
            'name.max'  => 'El campo nombre no debe contener más de 190 caracteres',
            'description.required'  => 'El campo descripción es obligatorio',
            'name.max'  => 'El campo descripción no debe contener más de 190 caracteres',
            'permissions.min'  => 'Debe asignar al menos 1 permiso',
        ];
        $validateArray = [
            'name'=>'required|max: 190',
            'description'=>'required|max: 190',
            'permissions' => 'min:1',
        ];
        $request->validate($validateArray,$messages);

        $role = Role::find(decode($id));
        $role->name =$request->name;
        $role->description =$request->description;
        $role->update();
        $permisos=$request->get('permissions');
        $role->permissions()->sync($permisos);
        $role->update();
        toastr()->info('Modificado con éxito.','Rol '.$role->name, ['positionClass' => 'toast-bottom-right']);
        Session::flash('messageRol','Para efectuar las modificaciones realizadas en este rol debe actualizar la asignación del rol en cada usuario perteneciente al mismo');
        $contid = $request->tabinput != null ? $request->tabinput : '';
        return  \Response::json(['success' => '1','contid'=> $contid]);
    }

    public function changestatus($id){
        $role = Role::findOrFail(decode($id));
        if ($role->active=='0') {
            $role->active='1';
            $role->save();
            toastr()->success('Activado correctamente.','Rol '.$role->name, ['positionClass' => 'toast-bottom-right']);
        }else {
            $role->active='0';
            $role->save();
            toastr()->error('Desactivado correctamente.','Rol '.$role->name, ['positionClass' => 'toast-bottom-right']);
        }
        return back();
    }

    public function destroy(Request $request, $id){
        $messages = [
            'rolBorrar.required'  => 'EL CAMPO CONTRASEÑA ES OBLIGATORIO',
        ];

        $request->validate([
            'rolBorrar' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, Auth::user()->password)) {
                    return $fail(__('La contraseña ingresada no coincide con la almacenada en el sistema.'));
                }
            }],
        ],$messages);
        $role = Role::findOrFail(decode($id));
        $role->permissions()->detach();
        $role->delete();
        toastr()->error('Eliminado correctamente.','Rol '.$role->name, ['positionClass' => 'toast-bottom-right']);
        return  \Response::json(['success' => '1']);
    }
}
