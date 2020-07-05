<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasdevNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('notas')) 
        {
            Schema::connection('controlplacas')->create('notas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_operador');
                $table->integer('id_dato');
                $table->text('nota');
                $table->date('fecha');
                $table->time('hora');
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
        Schema::connection('controlplacas')->dropIfExists('notas');
    }
}
