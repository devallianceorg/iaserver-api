<?php
Route::get('/', 'UbicacionFind@find');
Route::get('/codigo/{codigo}', 'UbicacionFind@findCodigo');

Route::get('/{id}', 'UbicacionAbm@show');
Route::post('/create','UbicacionAbm@create');
Route::put('/update','UbicacionAbm@update');
Route::post('/delete/{id}','UbicacionAbm@delete');