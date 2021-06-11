<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AoidataDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('aoi_ng')) 
        {
            Schema::connection('aoidata')->create('aoi_ng', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_maquina');
                $table->string('panel_barcode');
                $table->date('date');
                $table->time('time');
                $table->datetime('created_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('aoi_pointer')) 
        {
            Schema::connection('aoidata')->create('aoi_pointer', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('date');
                $table->time('time');
                $table->datetime('pointer');
                $table->timestamp('created_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('cuarentena')) 
        {
            Schema::connection('aoidata')->create('cuarentena', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_user_calidad');
                $table->text('motivo');
                $table->enum('tipo', ['CODE', 'OP', 'AOI']);
                $table->integer('id_maquina');
                $table->string('op');
                $table->datetime('created_at');
                $table->datetime('updated_at');
                $table->datetime('released_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('cuarentena_detalle')) 
        {
            Schema::connection('aoidata')->create('cuarentena_detalle', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_cuarentena');
                $table->string('barcode');
                $table->datetime('created_at');
                $table->datetime('updated_at');
                $table->datetime('released_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('cuarentena_pointer')) 
        {
            Schema::connection('aoidata')->create('cuarentena_pointer', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('op');
                $table->integer('id_user_calidad');
                $table->text('motivo');
                $table->enum('tipo', ['CODE', 'OP', 'AOI']);
                $table->integer('id_maquina');
                $table->datetime('pointer');
                $table->date('date');
                $table->time('time');
                $table->timestamps();
            });
        }

        if (!Schema::connection('aoidata')->hasTable('general')) 
        {
            Schema::connection('aoidata')->create('general', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('variable');
                $table->text('valor');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('history_inspeccion_panel')) 
        {
            Schema::connection('aoidata')->create('history_inspeccion_panel', function (Blueprint $table) {
                $table->bigIncrements('id_panel_history');
                $table->string('modo');
                $table->bigInteger('id');
                $table->integer('id_maquina');
                $table->string('panel_barcode');
                $table->string('programa');
                $table->date('fecha');
                $table->time('hora');
                $table->enum('turno',['N','M','T']);
                $table->enum('revision_aoi',['NG','OK','SCRAP']);
                $table->enum('revision_ins',['NG','OK','SCRAP']);
                $table->smallInteger('errores')->default('0');
                $table->smallInteger('falsos')->default('0');
                $table->smallInteger('reales')->default('0');
                $table->tinyInteger('bloques')->default('1');
                $table->enum('etiqueta',['E','V']);
                $table->tinyInteger('pendiente_inspeccion')->default('0');
                $table->smallInteger('test_machine_id');
                $table->smallInteger('program_name_id');
                $table->string('inspected_op');
                $table->string('semielaborado');
                $table->integer('id_user');
                $table->date('created_date');
                $table->time('created_time');
                $table->timestamp('dateTime');
                $table->string('insp_type')->default('machine');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('history_inspeccion_bloque')) 
        {
            Schema::connection('aoidata')->create('history_inspeccion_bloque', function (Blueprint $table) {
                $table->bigIncrements('id_bloque_history');
                $table->bigInteger('id_panel_history');
                $table->bigInteger('id');
                $table->string('barcode');
                $table->enum('etiqueta',['E','V']);
                $table->enum('revision_aoi',['NG','OK','SCRAP']);
                $table->enum('revision_ins',['NG','OK','SCRAP']);
                $table->smallInteger('errores');
                $table->smallInteger('falsos');
                $table->smallInteger('reales');
                $table->tinyInteger('bloque');

                $table->foreign('id_panel_history')->references('id_panel_history')->on('history_inspeccion_panel')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('history_inspeccion_detalle')) 
        {
            Schema::connection('aoidata')->create('history_inspeccion_detalle', function (Blueprint $table) {
                $table->bigIncrements('id_detalle_history');
                $table->bigInteger('id_bloque_history');
                $table->bigInteger('id_bloque');
                $table->string('referencia');
                $table->smallInteger('faultcode');
                $table->enum('estado',['REAL','FALSO','PENDIENTE','REPARADO']);

                $table->foreign('id_bloque_history')->references('id_bloque_history')->on('history_inspeccion_bloque')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('inspeccion_panel')) 
        {
            Schema::connection('aoidata')->create('inspeccion_panel', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_maquina');
                $table->string('panel_barcode');
                $table->string('programa');
                $table->date('fecha');
                $table->time('hora');
                $table->enum('turno',['N','M','T']);
                $table->enum('revision_aoi',['NG','OK','SCRAP']);
                $table->enum('revision_ins',['NG','OK','SCRAP']);
                $table->smallInteger('errores')->default('0');
                $table->smallInteger('falsos')->default('0');
                $table->smallInteger('reales')->default('0');
                $table->tinyInteger('bloques')->default('1');
                $table->enum('etiqueta',['E','V']);
                $table->tinyInteger('pendiente_inspeccion')->default('0');
                $table->smallInteger('test_machine_id');
                $table->smallInteger('program_name_id');
                $table->string('inspected_op');
                $table->string('semielaborado');
                $table->integer('id_user');
                $table->datetime('created_at');
                $table->datetime('updated_at');
                $table->date('created_date');
                $table->time('created_time');
                $table->bigInteger('first_history_inspeccion_panel');
                $table->bigInteger('last_history_inspeccion_panel');
                $table->string('insp_type')->default('machine');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('inspeccion_bloque')) 
        {
            Schema::connection('aoidata')->create('inspeccion_bloque', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_panel');
                $table->string('barcode');
                $table->enum('etiqueta',['E','V']);
                $table->enum('revision_aoi',['NG','OK','SCRAP']);
                $table->enum('revision_ins',['NG','OK','SCRAP']);
                $table->smallInteger('errores')->default('0');
                $table->smallInteger('falsos')->default('0');
                $table->smallInteger('reales')->default('0');
                $table->tinyInteger('bloque')->default('1');

                $table->foreign('id_panel')->references('id')->on('inspeccion_panel')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('inspeccion_detalle')) 
        {
            Schema::connection('aoidata')->create('inspeccion_detalle', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_bloque');
                $table->string('referencia');
                $table->smallInteger('faultcode');
                $table->enum('estado',['REAL','FALSO','PENDIENTE','REPARADO']);

                $table->foreign('id_bloque')->references('id')->on('inspeccion_bloque')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('route_op')) 
        {
            Schema::connection('aoidata')->create('route_op', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('op');
                $table->string('name');
                $table->tinyInteger('declare');
                $table->string('regex');
                $table->string('qty_etiquetas');
                $table->string('qty_bloques');
                $table->tinyInteger('is_secundaria');
                $table->string('cogiscan_partnumber');
                $table->string('qty_placas_x_panel');
                $table->string('qty_panel');
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('ia_traza')) 
        {
            Schema::connection('aoidata')->create('ia_traza', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_panel');
                $table->bigInteger('id_route');
                $table->timestamp('created_at');

                $table->foreign('id_panel')->references('id')->on('inspeccion_panel')->onDelete('cascade');
                $table->foreign('id_route')->references('id')->on('route_op')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('inspeccion_pendiente')) 
        {
            Schema::connection('aoidata')->create('inspeccion_pendiente', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_panel');
                $table->string('barcode');
                $table->dateTime('end_date');

                $table->foreign('id_panel')->references('id')->on('inspeccion_panel')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('ky_faultcode')) 
        {
            Schema::connection('aoidata')->create('ky_faultcode', function (Blueprint $table) {
                $table->bigIncrements('id_faultcode');
                $table->integer('faultcode');
                $table->string('descripcion');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('lanzamiento_op')) 
        {
            Schema::connection('aoidata')->create('lanzamiento_op', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('op');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->string('semielaborado');
                $table->string('qty');
                $table->tinyInteger('arrived');
                $table->enum('quarantine',['true','false'])->default('true');
                $table->timeStamp('timestamp');
                $table->integer('faultcode');
                $table->enum('aoi',['true','false'])->default('false');
                $table->timeStamps();
            });
        }

        if (!Schema::connection('aoidata')->hasTable('maquina')) 
        {
            Schema::connection('aoidata')->create('maquina', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('maquina');
                $table->tinyInteger('linea');
                $table->string('tipo');
                $table->string('proceso');
                $table->dateTime('ultima_inspeccion');
                $table->dateTime('ultima_inspeccion_iaserver');
                $table->dateTime('ping');
                $table->tinyInteger('active');
                $table->string('csv_path_id');
                $table->tinyInteger('auto_descarga');
                $table->timestamps();
            });
        }

        if (!Schema::connection('aoidata')->hasTable('maquina_csv_path')) 
        {
            Schema::connection('aoidata')->create('maquina_csv_path', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ruta');
                $table->string('tipo');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('pcb_data')) 
        {
            Schema::connection('aoidata')->create('pcb_data', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->string('programa');
                $table->tinyInteger('bloques');
                $table->text('segmentos');
                $table->string('tipo_maquina');
                $table->string('hash');
                $table->dateTime('fecha_modificacion');
                $table->string('libreria');
                $table->smallInteger('etiquetas');
                $table->tinyInteger('secundaria')->default('0');

            });
        }

        if (!Schema::connection('aoidata')->hasTable('procesar_pendiente')) 
        {
            Schema::connection('aoidata')->create('procesar_pendiente', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('barcode');
                $table->dateTime('fecha_maquina');
                $table->integer('id_maquina');
                $table->string('programa');
                $table->smallInteger('vtwin_program_name_id');
                $table->smallInteger('vtwin_test_machine_id');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('produccion')) 
        {
            Schema::connection('aoidata')->create('produccion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('barcode')->unique();
                $table->string('linea');
                $table->string('op');
                $table->smallInteger('line_id');
                $table->integer('puesto_id');
                $table->integer('id_maquina');
                $table->integer('modelo_id');
                $table->integer('id_stocker');
                $table->integer('id_v_stocker');
                $table->string('inf');
                $table->char('manual_mode');
                $table->integer('id_route_op');
                $table->integer('id_user');
                $table->enum('cogiscan',['N','Y','T'])->default('N');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('production')) 
        {
            Schema::connection('aoidata')->create('production', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('maquina');
                $table->string('linea');
                $table->string('programa');
                $table->date('fecha');
                $table->string('turno');
                $table->string('bloques');
                $table->string('inspected_op');
                $table->string('created_time');
                $table->time('max_created_time');
                $table->string('op');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->string('prod_aoi');
                $table->string('qty');
                $table->string('semielaborado');
                $table->string('cantidad');
                $table->string('prodDia');
                $table->string('totalInsercion');
                $table->string('totalInsercionPorOp');
                $table->string('target');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('production_day')) 
        {
            Schema::connection('aoidata')->create('production_day', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('produccion');
                $table->date('fecha');
                $table->integer('id_maquina');
                $table->string('maquina');
                $table->integer('linea');
                $table->integer('bloques');
                $table->string('inspected_op');
                $table->timestamp('created_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('rework_resume')) 
        {
            Schema::connection('aoidata')->create('rework_resume', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codigo');
                $table->string('nombre');
                $table->string('apellido');
                $table->string('nombre_completo');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->string('causo');
                $table->string('defecto');
                $table->string('referencia');
                $table->string('accion');
                $table->string('origen');
                $table->string('correctiva');
                $table->string('estado');
                $table->string('turno');
                $table->string('fecha');
                $table->string('hora');
                $table->string('sector');
                $table->string('area');
                $table->string('fotos');
                $table->string('reparaciones');
                $table->string('historico');
                $table->string('op');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('rns_faultcode')) 
        {
            Schema::connection('aoidata')->create('rns_faultcode', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->smallInteger('faultcode');
                $table->string('descripcion');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stat_resume')) 
        {
            Schema::connection('aoidata')->create('stat_resume', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('fecha');
                $table->string('turno');
                $table->string('linea');
                $table->string('programa');
                $table->string('op');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->integer('total_paneles');
                $table->integer('total_falso');
                $table->integer('total_real');
                $table->integer('promedio_falso_error');
                $table->integer('ng_aoi');
                $table->integer('ng_insp');
                $table->string('posicion');
                $table->string('defecto');
                $table->string('estado');
                $table->integer('total_posicion');
                $table->integer('total_defecto_real');
                $table->integer('total_real_placas');
                $table->decimal('porcentaje_posicion_real', 10, 0);
                $table->integer('total_bloques');
                $table->dateTime('executed_at');
                $table->string('resume_type')->default('first');
                $table->integer('id_maquina');
                $table->string('semielaborado');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stat_resume_false')) 
        {
            Schema::connection('aoidata')->create('stat_resume_false', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('fecha');
                $table->string('turno');
                $table->string('linea');
                $table->string('programa');
                $table->string('op');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->integer('total_paneles');
                $table->integer('total_falso');
                $table->integer('total_real');
                $table->integer('promedio_falso_error');
                $table->integer('ng_aoi');
                $table->integer('ng_insp');
                $table->string('posicion');
                $table->string('defecto');
                $table->string('estado');
                $table->integer('total_posicion');
                $table->integer('total_defecto_real');
                $table->integer('total_real_placas');
                $table->decimal('porcentaje_posicion_real', 10, 0);
                $table->integer('total_bloques');
                $table->dateTime('executed_at');
                $table->string('resume_type')->default('first');
                $table->integer('id_maquina');
                $table->string('semielaborado');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stocker')) 
        {
            Schema::connection('aoidata')->create('stocker', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('barcode')->unique();
                $table->string('aoi_barcode');
                $table->string('op');
                $table->tinyInteger('limite');
                $table->smallInteger('bloques');
                $table->tinyInteger('despachado')->default('0');
                $table->string('semielaborado');
                $table->dateTime('updated_at');
                $table->tinyInteger('declarado')->default('0');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stocker_detalle')) 
        {
            Schema::connection('aoidata')->create('stocker_detalle', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_stocker');
                $table->integer('id_panel');

                $table->foreign('id_stocker')->references('id')->on('stocker')->onDelete('cascade');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stocker_route')) 
        {
            Schema::connection('aoidata')->create('stocker_route', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('stocker_traza')) 
        {
            Schema::connection('aoidata')->create('stocker_traza', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_stocker');
                $table->integer('id_stocker_route');
                $table->integer('id_user');
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('transaccion_wip')) 
        {
            Schema::connection('aoidata')->create('transaccion_wip', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('barcode');
                $table->integer('trans_id');
                $table->integer('trans_ok');
                $table->string('trans_det');
                $table->dateTime('updated_at');
                $table->dateTime('created_at');
                $table->integer('id_panel');
                $table->integer('id_last_route');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('turnos')) 
        {
            Schema::connection('aoidata')->create('turnos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->enum('turno',['M','T','N']);
                $table->time('desde');
                $table->time('hasta');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('v_stocker')) 
        {
            Schema::connection('aoidata')->create('v_stocker', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('barcode');
                $table->string('op');
                $table->string('semielaborado');
                $table->string('aoi_barcode');
                $table->tinyInteger('limite');
                $table->tinyInteger('bloques');
                $table->timestamp('updated_at');
                $table->enum('estado',['OK','NG'])->default('OK');
            });
        }

        if (!Schema::connection('aoidata')->hasTable('v_stocker_detalle'))
        {
            Schema::connection('aoidata')->create('v_stocker_detalle', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_v_stocker');
                $table->integer('id_panel');
                $table->timestamp('timestamp');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('aoidata')->dropIfExists('aoi_ng');
        Schema::connection('aoidata')->dropIfExists('aoi_pointer');
        Schema::connection('aoidata')->dropIfExists('cuarentena');
        Schema::connection('aoidata')->dropIfExists('cuarentena_detalle');
        Schema::connection('aoidata')->dropIfExists('cuarentena_pointer');
        Schema::connection('aoidata')->dropIfExists('general');
        Schema::connection('aoidata')->dropIfExists('history_inspeccion_detalle');
        Schema::connection('aoidata')->dropIfExists('history_inspeccion_bloque');
        Schema::connection('aoidata')->dropIfExists('history_inspeccion_panel');
        Schema::connection('aoidata')->dropIfExists('inspeccion_detalle');
        Schema::connection('aoidata')->dropIfExists('inspeccion_bloque');
        Schema::connection('aoidata')->dropIfExists('inspeccion_panel');
        Schema::connection('aoidata')->dropIfExists('ia_traza');
        Schema::connection('aoidata')->dropIfExists('inspeccion_pendiente');
        Schema::connection('aoidata')->dropIfExists('ky_faultcode');
        Schema::connection('aoidata')->dropIfExists('lanzamiento_op');
        Schema::connection('aoidata')->dropIfExists('maquina');
        Schema::connection('aoidata')->dropIfExists('maquina_csv_path');
        Schema::connection('aoidata')->dropIfExists('pcb_data');
        Schema::connection('aoidata')->dropIfExists('procesar_pendiente');
        Schema::connection('aoidata')->dropIfExists('produccion');
        Schema::connection('aoidata')->dropIfExists('production');
        Schema::connection('aoidata')->dropIfExists('production_day');
        Schema::connection('aoidata')->dropIfExists('rework_resume');
        Schema::connection('aoidata')->dropIfExists('rns_faultcode');
        Schema::connection('aoidata')->dropIfExists('route_op');
        Schema::connection('aoidata')->dropIfExists('state_resume');
        Schema::connection('aoidata')->dropIfExists('state_resume_false');
        Schema::connection('aoidata')->dropIfExists('stocker');
        Schema::connection('aoidata')->dropIfExists('stocker_detalle');
        Schema::connection('aoidata')->dropIfExists('stocker_route');
        Schema::connection('aoidata')->dropIfExists('stocker_traza');
        Schema::connection('aoidata')->dropIfExists('transaccion_wip');
    }
}
