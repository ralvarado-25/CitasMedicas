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

// ========================================================================================
//                                    RUTAS DE ROLES
// ========================================================================================
// Ruta para el index (vista principal y listado)
Route::get('/roles', 'RoleController@index')->name('roles.index');
// Ruta para mostrar los datos generales de un rol
Route::get('/roles/show/{role}','RoleController@show')->name('roles.show');
// Ruta para ir a la vista donde se creara el rol
Route::get('/roles/create','RoleController@create')->name('roles.create');
// Ruta para guardar rol nuevo
Route::post('/roles_store','RoleController@store')->name('roles.store');
// Ruta para ir a la vista donde se editara el rol
Route::post('/roles/{role}','RoleController@update')->name('roles.update');
// Ruta para actualizar rol
Route::get('/roles/edit/{id}','RoleController@edit')->name('roles.edit');
// Ruta para actualizar rol
Route::get('/roles_change/{role}','RoleController@changestatus')->name('roles.changestatus');
// Ruta para eliminar rol
Route::post('/roles_delete/{id}','RoleController@destroy')->name('roles.destroy');


// ========================================================================================
//                                    RUTAS DE ROLES
// ========================================================================================
// Ruta para el index (vista principal y listado)
Route::get('/usuarios', 'UserController@index')->name('user.index');
// Ruta para mostrar los datos generales de un usuario
Route::get('/usuarios/{user}','UserController@show')->name('users.show');
// Ruta para ir a la vista donde se creara el usuario
Route::get('/usuarios_create','UserController@create')->name('users.create');
// Ruta para guardar usuario nuevo
Route::post('/usuarios_store','UserController@store')->name('users.store');
// Ruta para validar nombre de usuario
Route::post('/validar_user','UserController@validarUsername')->name('users.validar');
