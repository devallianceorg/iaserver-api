<?php
// En caso de ocupar la ruta por medio de VUE
Route::get('/', 'Npmpicker@index');

Route::get('/info/{fecha}/{id_linea}/{turno}', 'Npmpicker@GetLinea');
Route::get('/stat/{id_stat}', 'Npmpicker@GetStat');


