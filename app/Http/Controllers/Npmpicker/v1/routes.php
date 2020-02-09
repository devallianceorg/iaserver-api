<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Npmpicker@index');

Route::get('/resume/{fecha}', 'Npmpicker@GetPing');
Route::get('/resume/{fecha}/{id_linea}/{turno}/{estado?}', 'Npmpicker@GetFeeders');
Route::get('/stat/{id_stat}', 'Npmpicker@GetFeederDetail');

Route::prefix('ping')->group(function(){
  Route::post('/create','Abm\NpmpickerPingAbm@create');
  Route::put('/update','Abm\NpmpickerPingAbm@update');
  Route::post('/delete/{id}','Abm\NpmpickerPingAbm@delete');
});

