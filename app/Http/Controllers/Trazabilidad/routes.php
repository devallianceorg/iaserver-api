<?php
use Illuminate\Support\Facades\Route;


Route::prefix('trazabilidad')->group(function(){
  Route::match(['get', 'post'], '/find/{op?}', [
    'as' => 'trazabilidad.find.op',
    'uses' => 'Trazabilidad\Trazabilidad@findOp'
  ]);
});