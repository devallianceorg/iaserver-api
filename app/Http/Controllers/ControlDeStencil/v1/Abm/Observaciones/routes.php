<?php
Route::get('/', 'ObservacionesFind@find');
Route::get('/codigo/{codigo}', 'ObservacionesFind@byCodigoStencil');
Route::get('/operador/{id}', 'ObservacionesFind@byOperadorId');

Route::get('/{id}', 'ObservacionesAbm@show');
Route::post('/create','ObservacionesAbm@create');
Route::put('/update','ObservacionesAbm@update');
Route::post('/delete/{id}','ObservacionesAbm@delete');

