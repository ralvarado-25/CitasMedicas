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
        $filtro = 'ejemplo de variable';
        Session::put('item', '2.');
        return view("adminTemplate.users.index", compact('filtro'));
    }
}
