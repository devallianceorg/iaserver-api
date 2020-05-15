<?php
Route::get('/', 'ArmarioFind@find');

Route::get('/{id}', 'ArmarioAbm@show');
Route::post('/create','ArmarioAbm@create');
Route::put('/update','ArmarioAbm@update');
Route::post('/delete/{id}','ArmarioAbm@delete');