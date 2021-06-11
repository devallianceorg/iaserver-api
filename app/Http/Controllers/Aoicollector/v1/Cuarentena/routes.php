<?php

Route::resource('/cuarentena', 'CuarentenaAbm');

Route::post('/librear/multiple','LiberarCuarentena@multiple')
    ->name('aoicollector.cuarentena.liberar.multiple');

Route::post('/agregar/multiple/{id_cuarentena?}/{input?}/{motivo?}','AgregarCuarentena@multiple')
    ->name('aoicollector.cuarentena.agregar.multiple');
