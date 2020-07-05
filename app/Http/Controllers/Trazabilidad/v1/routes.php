<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Trazabilidad@index');

Route::match(['get', 'post'], '/find/{op?}', [
  'as' => 'trazabilidad.find.op',
  'uses' => 'Trazabilidad@findOp'
]);