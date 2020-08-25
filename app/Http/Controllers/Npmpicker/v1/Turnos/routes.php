<?php
Route::get('/', 'TurnosFind@find');
Route::get('/turno_actual', 'TurnosCtrl@getTurnoActual');

Route::get('/{id}', 'TurnosAbm@show');
Route::post('/create','TurnosAbm@create');
Route::put('/update','TurnosAbm@update');
Route::post('/delete/{id}','TurnosAbm@delete');