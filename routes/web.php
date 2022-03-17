<?php


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicioPaginaWeb');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* ---   UTILIZANDO MIDDLEWARE   --- */
Route::middleware(['auth'])->group(function(){
    require __DIR__.'/routes_b.php';
    require __DIR__.'/routes_o.php';
    require __DIR__.'/routes_r.php';
    require __DIR__.'/routes_k.php';
    require __DIR__.'/routes_m.php';
    require __DIR__.'/routes_j.php';
    require __DIR__.'/routes_d.php';
});


// Ruta para el index (vista principal y listado)
Route::get('/citas', 'CitasController@index')->name('citas.index');
Route::get('/especialidades', 'EspecialidadesController@index')->name('especialidades.index');
Route::get('/usuarios', 'UserController@index')->name('user.index');
Route::get('/roles', 'RoleController@index')->name('roles.index');
