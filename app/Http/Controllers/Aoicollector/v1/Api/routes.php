<?php
Route::group([
    'prefix' => 'api',
    'namespace'=>'Aoicollector\Api'], function() {

    Route::get('/verify/placa/{barcode}/{stage}', 'CollectorClient\CollectorClientApi@verifyBarcode');

    /*
        NOTA
    -------------
            Seria bueno aplicar un KEY de acceso a los service de cada planta, para evitar
        problemas futuros, como por ejemplo que planta5 utilice el service de planta6 seteando
        la ultima ruta de la placa de forma erronea.

        Esto se solucionaria modificando la ruta con una clave fija para cada planta por ej:

            Route::get('/{barcode}/ClaveSuperSecretaParaPlanta4/{stage}', 'Planta4\Planta4Api@estadoDePlaca');
            Route::get('/{barcode}/Clave512PepePizzaParaPlanta5/{stage}', 'Planta5\Planta5Api@estadoDePlaca');

        Luego enviarle la clave respectiva a la gente de sistema de cada planta, para que consuman el service.
    */
    //============================ ANDON ===============================
       Route::group([
        'prefix' => 'andon'], function() {

        // Route::get('/semana/{linea}', 'Andon\ControllerAndonApi@getAll');
        // Route::get('/production', 'Andon\ControllerAndonApi@addProduction');
        Route::get('/lines', 'Andon\ControllerAndonApi@getLineAll');
        Route::get('/data/{idLinea}', 'Andon\ControllerAndonApi@data');
        Route::get('/info/{barcode}/{data}', 'Andon\ControllerAndonApi@info');
        Route::get('/pruebas', 'Andon\ControllerAndonApi@funtionPruebas');

    });
    //============================ CUARENTENA AUTOMATICA ===============================
    Route::group([
        'prefix' => 'cuarentena'], function() {
        Route::get('/data', 'Cuarentena\ControllerCuarentena@data');
    });
    //=============================== PLANTA 4 ======================================
    Route::group([
        'prefix' => 'planta4',
        'middleware' => 'responselog:planta4'], function() {

        Route::get('/{barcode}/{stage}', 'Planta4\Planta4Api@estadoDePlaca');
    });

    //=============================== PLANTA 5 ======================================
    Route::group([
        'prefix' => 'planta5',
        'middleware' => 'responselog:planta5'], function() {

        Route::get('/{barcode}/{stage}', 'Planta5\Planta5Api@estadoDePlacaV1');
    });

    Route::group([
        'prefix' => 'plantatest',
        'middleware' => 'responselog:planta5'], function() {

        Route::get('/{barcode}/{stage}', 'Planta5\Planta5Api@estadoDePlacaV1');
    });

    //=============================== PLANTA 5 SLIM ======================================
    Route::group([
        'prefix' => 'planta5',
        'middleware' => 'responselog:planta5'], function() {

        Route::get('/slim/{barcode}/{stage}', 'Planta5\Slim\Planta5ApiSlim@estadoDePlaca');
        
    });

    //=============================== PLANTA 6 ======================================
    Route::group([
        'prefix' => 'planta6',
        'middleware' => 'responselog:planta6'], function() {

        Route::get('/{barcode}/{stage}', 'Planta6\Planta6Api@estadoDePlaca');
    });

    //=============================== SMT COMPONENTS ================================
    Route::group([
        'prefix' => 'smtcomponent'], function() {
            Route::get('/ing/{model}', 'Components\ComponentsApi@ingenieria');
            Route::get('/lote/{ingId}', 'Components\ComponentsApi@lote');
    });
});

// ======================
// ======================
// ======= RUTAS MIGRADAS
// ======================
// ======================

//=========================== CLIENTE AOICOLLECTOR ==============================
Route::get('/placa/{barcode}/{verifyDeclared?}/{proceso?}', 'CollectorClient\CollectorClientApi@inspectedBarcode'); // OK
Route::get('/prodinfo/{aoibarcode}/{filter?}', 'CollectorClient\CollectorClientApi@prodInfo');
Route::get('/prodinfoall', 'CollectorClient\CollectorClientApi@prodInfoAll');
Route::get('/prodlist', 'CollectorClient\CollectorClientApi@prodList');
Route::get('/declarar/{panelBarcode}', 'CollectorClient\CollectorClientApi@declararPanel');

//============================ EVENTOS DEL COLLECTOR ===============================
Route::group([
    'prefix' => 'event'], function() {
    Route::get('/inspection/{panelbarcode}', 'CollectorClient\CollectorClientEventApi@inspection');
});

//============================ CONTROL DE PLACAS ===============================
Route::group([
    'prefix' => 'controldeplacas'], function() {

    Route::get('/setroute/{stkbarcode}', 'ControldePlacas\ControlDePlacasApi@setroute');
    Route::get('/verifystocker/{stkbarcode}', 'ControldePlacas\ControlDePlacasApi@verifyStocker');
    Route::get('/infostocker/{stkbarcode}', 'ControldePlacas\ControlDePlacasApi@infoStocker');
    Route::get('/opinfo/{op}', 'ControldePlacas\ControlDePlacasApi@opinfo');
});

// Route::get('/nc/{host}', 'Nc\NcApi@nc'); // No se sabe para que se usa.
