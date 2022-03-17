<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\NuevoUsuario;
use Session;
use PDF;
use Mail;
class RoleController extends Controller
{
    public function index (Request $request){
        $filtro = 'ejemplo de variable';
        Session::put('item', '3.');
        return view("adminTemplate.roles.index", compact('filtro'));
    }
}
