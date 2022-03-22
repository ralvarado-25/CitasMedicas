<?php

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
