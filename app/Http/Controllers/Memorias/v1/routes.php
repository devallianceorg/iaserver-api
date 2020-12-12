<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Memorias@index')->name('memorias.index');
Route::post('/zebra/{op?}/{cantidad?}/{id?}', 'Memorias@zebraPrint')->name('memorias.zebra.print');

Route::get('/cartelera', 'Memorias@cartelera/{filtrar_modelo?}/{filtrar_lote?/{filtrar_op?}}')->name('memorias.index');