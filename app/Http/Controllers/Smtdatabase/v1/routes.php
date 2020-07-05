<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Smtdatabase@index');
Route::get('/modelos/get','Smtdatabase@QueryModels');
Route::get('/lotes/get','Smtdatabase@QueryBatch');
Route::put('/op/update/{modo}/{op}/{total}','Smtdatabase@IncProductionOpBy');
Route::get('/modelo/{materialId}','Smtdatabase@ModeloLoteByMaterialId');

// Materiales
Route::get('/material/get','Smtdatabase@CheckMaterial');
Route::get('/material/descripcion/','Smtdatabase@QueryDesc');
Route::get('/material/buscar/{componente?}/{likeMode?}','Smtdatabase@findComponente');
// END Materiales

// Semielaborados
Route::get('/semielaborado/buscar/{modelo}','Smtdatabase@allSemielaboradoByModelo');
// END Semielaborados

// Orden de Trabajo
Route::post('/ordentrabajo/create','Abm\OrdenTrabajoAbm@create');
Route::put('/ordentrabajo/update','Abm\OrdenTrabajoAbm@update');
Route::post('/ordentrabajo/delete','Abm\OrdenTrabajoAbm@delete');



