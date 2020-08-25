<?php
Route::get('/', 'TensionFind@find');
Route::get('/codigo/{codigo}', 'TensionFind@findCodigo');
Route::get('/operador/{id}', 'TensionFind@findOperadorId');

Route::get('/{id}', 'TensionAbm@show');
Route::post('/create','TensionAbm@create');
Route::put('/update','TensionAbm@update');
Route::post('/delete/{id}','TensionAbm@delete');