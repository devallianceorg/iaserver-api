<?php
Route::get('/', 'Npmpicker@index');

Route::get('/resume/{fecha}', 'Npmpicker@GetPing');
Route::get('/resume/{fecha}/{id_linea}/{turno}/{estado?}', 'Npmpicker@GetFeeders');
Route::get('/stat/{id_stat}', 'Npmpicker@GetFeederDetail');