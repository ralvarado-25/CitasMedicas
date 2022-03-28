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

    // ========================================================================================
    //                                    RUTAS DE ROLES
    // ========================================================================================
    Route::group(['middleware' => ['permission:roles.index']], function () {
        // Ruta para el index (vista principal y listado)
        Route::get('/roles', 'RoleController@index')->name('roles.index');
    });
    Route::group(['middleware' => ['permission:roles.show']], function () {
        // Ruta para mostrar los datos generales de un rol
        Route::get('/roles/show/{role}','RoleController@show')->name('roles.show');
    });
    Route::group(['middleware' => ['permission:roles.create']], function () {
        // Ruta para ir a la vista donde se creara el rol
        Route::get('/roles/create','RoleController@create')->name('roles.create');
        // Ruta para guardar rol nuevo
        Route::post('/roles_store','RoleController@store')->name('roles.store');
    });
    Route::group(['middleware' => ['permission:roles.edit']], function () {
        // Ruta para ir a la vista donde se editara el rol
        Route::post('/roles/{role}','RoleController@update')->name('roles.update');
        // Ruta para actualizar rol
        Route::get('/roles/edit/{id}','RoleController@edit')->name('roles.edit');
    });
    Route::group(['middleware' => ['permission:roles.changestatus']], function () {
        // Ruta para actualizar rol
        Route::get('/roles_change/{role}','RoleController@changestatus')->name('roles.changestatus');
    });
    Route::group(['middleware' => ['permission:roles.destroy']], function () {
        // Ruta para eliminar rol
        Route::post('/roles_delete/{id}','RoleController@destroy')->name('roles.destroy');
    });

    // ========================================================================================
    //                                    RUTAS DE USUARIOS
    // ========================================================================================
    // Ruta para el index (vista principal y listado)
    Route::group(['middleware' => ['permission:users.index']], function () {
        Route::get('/usuarios', 'UserController@index')->name('user.index');
    });

    // Ruta para mostrar los datos generales de un usuario
    Route::group(['middleware' => ['permission:users.show']], function () {
        Route::get('/usuarios/{user}','UserController@show')->name('users.show');
    });

    Route::group(['middleware' => ['permission:users.create']], function () {
        // Ruta para ir a la vista donde se creara el usuario
        Route::get('/usuarios_create','UserController@create')->name('users.create');
        // Ruta para guardar usuario nuevo
        Route::post('/usuarios_store','UserController@store')->name('users.store');
    });

    Route::group(['middleware' => ['permission:users.edit']], function () {
        // Ruta para ir a la vista donde se editara el usuario
        Route::get('/usuarios/edit/{user}','UserController@edit')->name('users.edit');
        // Funcion para editar el usuario
        Route::post('/usuarios_update/{user}','UserController@update')->name('users.update');
        //  ACTUALIZAR ROL
        Route::put('/users/{user}/rol','UserController@updaterol')->name('updaterol');
    });

    Route::group(['middleware' => ['permission:users.profile']], function () {
        // PERFIL DE USUARIOS
        Route::get('/perfil_usuario','UserController@perfil')->name('perfil');
        Route::post('updateprofile/{user}','UserController@updateprofile')->name('updateprofile');
    });

    Route::group(['middleware' => ['permission:users.changestatus']], function () {
        // CAMBIAR ESTADO DE USUARIOS
        Route::get('/users/modalCambEstado/{id}', 'UserController@modalCambioEstado')->name('users.modalDelete');
        Route::post('/users/cambiarestado/{id}','UserController@cambiarestado')->name('users.cambiarestado');
    });

    Route::group(['middleware' => ['permission:users.destroy']], function () {
        // ELIMINAR USUARIOS
        Route::post('/users_delete/{user}','UserController@destroy')->name('users.destroy');
        Route::get('/users/modalDelete/{id}', 'UserController@modalDelete')->name('users.modalDelete');
    });

    // CAMBIAR IMAGEN DE AVATAR
    Route::post('/useravatar', 'UserController@uploadAvatarImagen')->name('users.avatar');
    // Ruta para validar nombre de usuario
    Route::post('/validar_user','UserController@validarUsername')->name('users.validar');

    // ========================================================================================
    //                                    RUTAS DE ESPECIALIDADES
    // ========================================================================================
    Route::group(['middleware' => ['permission:especialidades.index']], function () {
        Route::get('/especialidades', 'EspecialidadesController@index')->name('especialidades.index');
        // Ruta para mostrar los datos generales de una especialidad
        Route::get('/especialidades/{id}','EspecialidadesController@show')->name('especialidades.show');
    });
    Route::group(['middleware' => ['permission:especialidades.create']], function () {
        // Ruta para guardar especialidad nueva
        Route::post('/especialidad_store','EspecialidadesController@store')->name('especialidades.store');
    });
    Route::group(['middleware' => ['permission:especialidades.state']], function () {
        Route::get('/especialidad/modalCambEstado/{id}', 'EspecialidadesController@modalCambioEstado')->name('especialidades.modalEstado');
        Route::post('/especialidad/state/{id}/', 'EspecialidadesController@cambiarestado')->name('especialidades.changestatus');
    });
    Route::group(['middleware' => ['permission:especialidades.edit']], function () {
        Route::get('/especialidad/editmodal/{id}', 'EspecialidadesController@modalEdit')->name('especialidades.editmodal');
        Route::post('/especialidad/update/{id}', 'EspecialidadesController@update')->name('especialidades.update');
    });
    Route::group(['middleware' => ['permission:especialidades.delete']], function () {
        Route::get('/especialidad/deletemodal/{id}', 'EspecialidadesController@modalDelete')->name('especialidades.deletemodal');
        Route::delete('/especialidad/destroy/{id}', 'EspecialidadesController@destroy')->name('especialidades.destroy');
    });

    // ========================================================================================
    //                                    RUTAS DE CITAS
    // ========================================================================================
    Route::group(['middleware' => ['permission:citas.index|citas.myindex']], function () {
        // Ruta para el index (vista principal y listado)
        Route::get('/citas', 'CitasController@index')->name('citas.index');
    });
    Route::group(['middleware' => ['permission:citas.create']], function () {
        // Ruta para guardar especialidad nueva
        Route::post('/cita_store','CitasController@store')->name('citas.store');
    });
    Route::group(['middleware' => ['permission:citas.validar']], function () {
        Route::get('/cita/modalCambEstado/{id}', 'CitasController@modalCambioEstado')->name('citas.modalEstado');
        Route::post('/cita/state/{id}/', 'CitasController@updateState')->name('citas.state');
    });
    Route::group(['middleware' => ['permission:citas.edit']], function () {
        Route::get('/cita/editmodal/{id}', 'CitasController@modalEdit')->name('citas.editmodal');
        Route::post('/cita/update/{id}', 'CitasController@update')->name('citas.update');
    });
    Route::group(['middleware' => ['permission:citas.delete']], function () {
        Route::get('/cita/deletemodal/{id}', 'CitasController@modalDelete')->name('citas.deletemodal');
        Route::delete('/cita/destroy/{id}', 'CitasController@destroy')->name('citas.destroy');
    });
    Route::group(['middleware' => ['permission:citas.export']], function () {
        // Exportar PDF
        Route::get('/cita_pdf', 'CitasController@exportPdf')->name('citas.export');
    });









});


