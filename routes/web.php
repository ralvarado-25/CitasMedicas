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

    // Ruta para el index (vista principal y listado)
    Route::get('/citas', 'CitasController@index')->name('citas.index');

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
    //                                    RUTAS DE USUARIOS
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
    // Ruta para ir a la vista donde se editara el usuario
    Route::get('/usuarios/edit/{user}','UserController@edit')->name('users.edit');
    // Funcion para editar el usuario
    Route::post('/usuarios_update/{user}','UserController@update')->name('users.update');
    // CAMBIAR IMAGEN DE AVATAR
    Route::post('/useravatar', 'UserController@uploadAvatarImagen')->name('users.avatar');
    //  ACTUALIZAR ROL
    Route::put('/users/{user}/rol','UserController@updaterol')->name('updaterol');

    // PERFIL DE USUARIOS
    Route::get('/perfil_usuario','UserController@perfil')->name('perfil');
    Route::post('updateprofile/{user}','UserController@updateprofile')->name('updateprofile');

    // CAMBIAR ESTADO DE USUARIOS
    Route::get('/users/modalCambEstado/{id}', 'UserController@modalCambioEstado')->name('users.modalDelete');
    Route::post('/users/cambiarestado/{id}','UserController@cambiarestado')->name('users.cambiarestado');

    // ELIMINAR USUARIOS
    Route::post('/users_delete/{user}','UserController@destroy')->name('users.destroy');
    Route::get('/users/modalDelete/{id}', 'UserController@modalDelete')->name('users.modalDelete');

    // ========================================================================================
    //                                    RUTAS DE ESPECIALIDADES
    // ========================================================================================
    Route::get('/especialidades', 'EspecialidadesController@index')->name('especialidades.index');
    // Ruta para guardar especialidad nueva
    Route::post('/especialidad_store','EspecialidadesController@store')->name('especialidades.store');
    // Ruta para mostrar los datos generales de una especialidad
    Route::get('/especialidades/{id}','EspecialidadesController@show')->name('especialidades.show');

    Route::get('/especialidad/editmodal/{id}', 'EspecialidadesController@modalEdit')->name('especialidades.editmodal');
    Route::post('/especialidad/update/{id}', 'EspecialidadesController@update')->name('especialidades.update');
    Route::get('/especialidad/deletemodal/{id}', 'EspecialidadesController@modalDelete')->name('especialidades.deletemodal');
    Route::delete('/especialidad/destroy/{id}', 'EspecialidadesController@destroy')->name('especialidades.destroy');

    Route::get('/especialidad/modalCambEstado/{id}', 'EspecialidadesController@modalCambioEstado')->name('especialidades.modalEstado');
    Route::post('/especialidad/state/{id}/', 'EspecialidadesController@cambiarestado')->name('especialidades.changestatus');

    // ========================================================================================
    //                                    RUTAS DE CITAS
    // ========================================================================================
    // Ruta para el index (vista principal y listado)
    Route::get('/citas', 'CitasController@index')->name('citas.index');
    // Ruta para guardar especialidad nueva
    Route::post('/cita_store','CitasController@store')->name('citas.store');

    Route::get('/cita/editmodal/{id}', 'CitasController@modalEdit')->name('citas.editmodal');
    Route::post('/cita/update/{id}', 'CitasController@update')->name('citas.update');
    Route::get('/cita/deletemodal/{id}', 'CitasController@modalDelete')->name('citas.deletemodal');
    Route::delete('/cita/destroy/{id}', 'CitasController@destroy')->name('citas.destroy');

    Route::get('/cita/modalCambEstado/{id}', 'CitasController@modalCambioEstado')->name('citas.modalEstado');
    Route::post('/cita/state/{id}/', 'CitasController@cambiarestado')->name('citas.changestatus');
});


