<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasCantidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('cantidad')) 
        {
            Schema::connection('memorias')->create('cantidad', function (Blueprint $table) {
                $table->bigIncrements('id_cantidad');
                $table->integer('id_programador');
                $table->integer('zocalo1');
                $table->integer('zocalo2');
                $table->integer('zocalo3');
                $table->integer('zocalo4');
                $table->integer('zocalo5');
                $table->integer('zocalo6');
                $table->integer('zocalo7');
                $table->integer('zocalo8');
                $table->timestamps();
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
        Schema::connection('memorias')->dropIfExists('cantidad');
    }
}
