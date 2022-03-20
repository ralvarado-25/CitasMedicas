<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\NuevoUsuario;

use Spatie\Permission\Models\Role;
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

}
