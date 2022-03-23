<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\NuevoUsuario;
use Illuminate\Http\Request;
use Session;
use PDF;
use Mail;

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
}
