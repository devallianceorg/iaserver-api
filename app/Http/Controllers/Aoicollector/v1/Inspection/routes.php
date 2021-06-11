<?php

Route::get('/','InspectionController@listDefault');

Route::prefix('inspection')->group(function()
{
    // Pagina principal de inspecciones
    Route::get('/',  [
        'as' => 'aoicollector.inspection.index',
        'uses' => 'Aoicollector\Inspection\InspectionController@listDefault'
    ]);

    Route::match(['get', 'post'],'/defectos/periodo', [
        'as' => 'aoicollector.inspection.defectos.periodo',
        'uses' => 'Aoicollector\Inspection\InspectionController@defectosPeriodo'
    ]);

    //Buscar por Referencias
    Route::prefix('byreferences')
        ->namespace('Aoicollector\Inspection')->group(function()
        {
            Route::get('/', [
                'as' => 'aoicollector.inspection.byreference',
                'uses' => 'InspectionController@searchByReferences'
            ]);
            Route::post('/find',[
                'as' =>'aoicollector.inspection.byreference.find',
                'uses' => 'FindInspection@findByReference'
            ]);
            Route::post('/find/multiple',[
                'as' =>'aoicollector.inspection.byreference.find.multiple',
                'uses' => 'FindInspection@findByReferenceMultiple'
            ]);
        }
    );


    // Exportar inspecciones
    Route::prefix('export')->group(function()
    {
        Route::get('/bloques/{id_maquina}/{fecha}/{minormax}',  [
            'as' => 'aoicollector.inspection.export.bloques',
            'uses' => 'Aoicollector\Inspection\InspectionExport@bloquesToExcel'
        ]);

        Route::get('/panel/{id_maquina}/{fecha}/{minormax}',  [
            'as' => 'aoicollector.inspection.export.panel',
            'uses' => 'Aoicollector\Inspection\InspectionExport@toExcel'
        ]);
    });

    // Lista de inspecciones filtradas por maquina
    Route::get('/show/{id_maquina}/{pagina?}',  [
        'as' => 'aoicollector.inspection.show',
        'uses' => 'Aoicollector\Inspection\InspectionController@listWithFilter'
    ]);

    // Lista de inspecciones filtradas por op
    Route::get('/showop/{op}/{pagina?}',  [
        'as' => 'aoicollector.inspection.showop',
        'uses' => 'Aoicollector\Inspection\InspectionController@listWithOpFilter'
    ]);

    Route::prefix('search')->group(function()
    {
        Route::get('/reference/{reference}/{id_maquina}/{turno}/{fecha}/{programa}/{realOFalso}/{type}', [
            'as' => 'aoicollector.inspection.search.reference',
            'uses' => 'Aoicollector\Inspection\InspectionController@searchReference'
        ]);

        Route::match(['get', 'post'],'/multiplesearch', [
            'as' => 'aoicollector.inspection.multiplesearch',
            'uses' => 'Aoicollector\Inspection\InspectionController@multipleSearchBarcode'
        ]);

        Route::match(['get', 'post'],'/', [
            'as' => 'aoicollector.inspection.search',
            'uses' => 'Aoicollector\Inspection\InspectionController@searchBarcode'
        ]);

        Route::get('/{barcode}/{view?}', [
            'as' => 'aoicollector.inspection.search.get',
            'uses' => 'Aoicollector\Inspection\InspectionController@searchBarcode'
        ]);
    });

    // Lista bloques de un panel
    Route::get('/blocks/{id_panel}',  [
        'as' => 'aoicollector.inspection.blocks',
        'uses' => 'Aoicollector\Inspection\InspectionController@listBlocks'
    ]);

    // Lista detalles de un bloque
    Route::get('/detail/{id_block}/{id_panel?}',  [
        'as' => 'aoicollector.inspection.detail',
        'uses' => 'Aoicollector\Inspection\InspectionController@listDetail'
    ]);

    
});

Route::prefix('admin')->group(function()
{
    Route::get('/forceok/{barcode}', 'InspectionController@forceOK')->name('aoicollector.inspection.admin.forceok');

    Route::post('/forceok/multiple', 'InspectionController@forceOKMultiple')->name('aoicollector.inspection.admin.multiple.forceok');
    Route::post('/createinspection', 'InspectionController@createInspection')->name('aoicollector.inspection.admin.createinspection');
});