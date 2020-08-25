<?php
Route::get('/', 'DataFind@find');
Route::get('/byidstat/{id_stat}', 'DataFind@byIdStat');

Route::get('/{id}', 'DataAbm@show');
Route::post('/create','DataAbm@create');
Route::put('/update','DataAbm@update');
Route::post('/delete/{id}','DataAbm@delete');
