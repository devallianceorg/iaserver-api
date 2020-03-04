<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Npmpicker@index');

Route::get('/resume/{fecha?}', 'Npmpicker@GetPing');
Route::get('/resume/{fecha}/{id_linea}/{turno}/{estado?}', 'Npmpicker@GetFeeders');
Route::get('/stat/{id_stat}', 'Npmpicker@GetFeederDetail');

Route::prefix('ping')->group(function(){
  Route::post('/create','Abm\NpmpickerPingAbm@create');
  Route::put('/update','Abm\NpmpickerPingAbm@update');
  Route::put('/update/flag','Abm\NpmpickerPingAbm@updateFlag');
  Route::post('/delete/{id}','Abm\NpmpickerPingAbm@delete');
});

Route::prefix('stat')->group(function(){
  Route::get('/info/get','Npmpicker@GetStatInfo');
  Route::post('/create','Abm\NpmpickerStatAbm@create');
  Route::put('/update','Abm\NpmpickerStatAbm@update');
  Route::post('/delete/{id}','Abm\NpmpickerStatAbm@delete');
});

Route::prefix('data')->group(function(){
  Route::post('/create','Abm\NpmpickerDataAbm@create');
  Route::put('/update','Abm\NpmpickerDataAbm@update');
  Route::post('/delete/{id}','Abm\NpmpickerDataAbm@delete');
});

Route::prefix('turnos')->group(function(){
  Route::get('/get','Npmpicker@GetTurno');
  Route::post('/create','Abm\NpmpickerTurnosAbm@create');
  Route::put('/update','Abm\NpmpickerTurnosAbm@update');
  Route::post('/delete/{id}','Abm\NpmpickerTurnosAbm@delete');
});

