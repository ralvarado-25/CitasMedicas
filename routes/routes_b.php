<?php

// ========================================================================================
//                                         RUTAS DE EJEMPLO
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

