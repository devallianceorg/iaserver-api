<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'StencilFind@find');
Route::get('/codigo/{codigo}', 'StencilFind@findCodigo');

Route::get('/{id}', 'StencilAbm@show');
Route::post('/create','StencilAbm@create');
Route::put('/update','StencilAbm@update');
Route::post('/delete/{id}','StencilAbm@delete');