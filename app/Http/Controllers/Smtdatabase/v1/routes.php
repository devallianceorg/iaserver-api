<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Smtdatabase@index');
Route::get('/modelos/get','Smtdatabase@QueryModels');
Route::get('/lotes/get','Smtdatabase@QueryBatch');
Route::put('/op/update/{modo}/{op}/{total}','Smtdatabase@IncProductionOpBy');
Route::get('/modelo/{materialId}','Smtdatabase@ModeloLoteByMaterialId');
Route::get('/material/descripcion/','Smtdatabase@QueryDesc');
Route::get('/material/get','Smtdatabase@CheckMaterial');



