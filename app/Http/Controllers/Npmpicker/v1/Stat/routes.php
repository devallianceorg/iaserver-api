<?php
Route::get('/', 'StatFind@find');
Route::get('/feeders/{fecha}/{id_linea}/{turno}/{estado?}', 'StatFind@getFeeders');

Route::get('/{id}', 'StatAbm@show');
Route::post('/create','StatAbm@create');
Route::put('/update','StatAbm@update');
Route::post('/delete/{id}','StatAbm@delete');