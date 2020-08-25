<?php
Route::get('/', 'PingFind@find');
Route::get('/bylinea/{fecha?}', 'PingFind@byLinea');

Route::get('/{id}', 'PingAbm@show');
Route::post('/create','PingAbm@create');
Route::put('/update','PingAbm@update');
Route::post('/delete/{id}','PingAbm@delete');

