<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasdevReprocesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('reproceso')) 
        {
            Schema::connection('controlplacas')->create('reproceso', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('modelo');
                $table->string('lote');
                $table->string('placa');
                $table->integer('cantidad');
                $table->date('fecha');
                $table->time('hora');
                $table->integer('id_turno');
                $table->integer('id_sector');
                $table->integer('id_destino');
            });
        }

        if (!Schema::connection('controlplacas')->hasTable('reproceso_notas')) 
        {
            Schema::connection('controlplacas')->create('reproceso_notas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_operador');
                $table->integer('id_reproceso');
                $table->text('nota');
                $table->date('fecha');
                $table->time('hora');
                $table->boolean('flag');
            });
        }

        if (!Schema::connection('controlplacas')->hasTable('reproceso_recepcion')) 
        {
            Schema::connection('controlplacas')->create('reproceso_recepcion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_reproceso');
                $table->integer('id_operador');
                $table->dateTime('fecha');
                $table->dateTime('fecha_reenvio');
                $table->dateTime('fecha_confirmacion');
                $table->boolean('flag');
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
        Schema::connection('controlplacas')->dropIfExists('reproceso');
        Schema::connection('controlplacas')->dropIfExists('reproceso_notas');
        Schema::connection('controlplacas')->dropIfExists('reproceso_recepcion');
    }
}
