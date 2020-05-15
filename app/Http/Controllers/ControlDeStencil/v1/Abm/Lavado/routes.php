<?php
Route::get('/', 'LavadoFind@find');
Route::get('/codigo/{codigo}', 'LavadoFind@byCodigo');
Route::get('/operador/{id}', 'LavadoFind@byOperadorId');

Route::get('/{id}', 'LavadoAbm@show');
Route::post('/create','LavadoAbm@create');
Route::put('/update','LavadoAbm@update');
Route::post('/delete/{id}','LavadoAbm@delete');