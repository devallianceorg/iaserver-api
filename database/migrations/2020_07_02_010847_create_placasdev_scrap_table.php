<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasdevScrapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('scrap')) 
        {
            Schema::connection('controlplacas')->create('scrap', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('modelo');
                $table->string('lote');
                $table->string('placa');
                $table->integer('cantidad');
                $table->date('fecha');
                $table->time('hora');
                $table->integer('id_turno');
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
        Schema::connection('controlplacas')->dropIfExists('scrap');
    }
}
