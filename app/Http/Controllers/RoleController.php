<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\NuevoUsuario;

use Spatie\Permission\Models\Role;
use App\Permission;
use Session;
use PDF;
use Mail;
class RoleController extends Controller
{
    public function index (Request $request){
        $roles = Role::get();
        Session::put('item', '3.');
        return view("adminTemplate.roles.index", compact('roles'));
    }

    public function show($id){
        $role = Role::findOrFail(decode($id));
        $permissions = $role->permissions()->where('active',1)->orderBy('parent_id')->get();
        Session::put('item', '3.');
        return view('adminTemplate.roles.show',compact('role', 'permissions'));
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

}
