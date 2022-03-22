<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Cookie;
use Session;
use Auth;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        $data1 = Cookie::get('login1');
        $data2 = Cookie::get('login2');
        return view('auth.login', compact('data1', 'data2'));
    }

    public function login(){
        $cred = $this->validate(request(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($cred)) {
            if ( auth()->user()->active == 1 ) {
                if (request()->remember) {
                    $lifetime = time() + 60 * 60 * 24 * 365;
                    Cookie::queue(Cookie::make('login1', request()->username, $lifetime));
                    Cookie::queue(Cookie::make('login2', request()->password, $lifetime));
                }else{
                    if(Cookie::has('login1') && Cookie::has('login1')){
                        Cookie::queue(Cookie::forget('login1'));
                        Cookie::queue(Cookie::forget('login2'));
                    }
                }
                return redirect()->action('HomeController@index');
            } else
                Auth::logout();
        }
        return back()->withErrors(['username' => 'Error de usuario', 'password' => 'Error de contraseña']);
    }

}
