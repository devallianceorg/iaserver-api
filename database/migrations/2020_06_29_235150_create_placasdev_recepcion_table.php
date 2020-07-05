<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasdevRecepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('recepcion')) 
        {
            Schema::connection('controlplacas')->create('recepcion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_dato');
                $table->integer('id_operador');
                $table->boolean('flag');
                $table->dateTime('fecha');
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
        Schema::connection('controlplacas')->dropIfExists('recepcion');
    }
}
