<?php

// ========================================================================================
//                                    RUTAS DE EJEMPLO CAMBIAR
// ========================================================================================

// Ruta para el index (vista principal y listado)
Route::get('/ejemplo', 'EjemploController@index')->name('ejemplo.index');
// Ruta para mostrar los datos generales de un registro
Route::get('/ejemplo/show/{id}', 'EjemploController@index')->name('ejemplo.index');
// Ruta para guardar registro nuevo
Route::post('/ejemplo/store', 'EjemploController@store')->name('ejemplo.store');
// Ruta para actualizar registro
Route::post('/ejemplo/update/{id}', 'EjemploController@update')->name('ejemplo.update');
// Ruta para eliminar registro
Route::delete('/ejemplo/destroy/{id}', 'EjemploController@destroy')->name('ejemplo.destroy');
// Cambiar estado de registro
Route::get('/ejemplo/state/{id}/{estado}', 'EjemploController@cambiarEstado')->name('ejemplo.estado');
// Exportar PDF
Route::get('/ejemplo/pdf', 'EjemploController@exportPdf')->name('ejemplo.pdf');
// Ruta de ejemplo para enviar mail
Route::get('/enviarMail', 'EjemploController@enviarMail')->name('ejemplo.mail');
// Crear plantilla de mails
Route::get('/plantillaMail', 'EjemploController@plantillaMail')->name('ejemplo.mail');


// ========================================================================================
//                                    RUTAS DE ROLES
// ========================================================================================
Route::get('/roles', 'RoleController@index')->name('roles.index');
Route::get('/roles/show/{role}','RoleController@show')->name('roles.show');

Route::post('/roles/{role}','RoleController@update')->name('roles.update');
Route::get('/roles/edit/{id}','RoleController@edit')->name('roles.edit');
Route::get('/roles_change/{role}','RoleController@changestatus')->name('roles.changestatus');
Route::get('/roles/create','RoleController@create')->name('roles.create');
Route::post('/roles_store','RoleController@store')->name('roles.store');
Route::post('/roles_delete/{id}','RoleController@destroy')->name('roles.destroy');
