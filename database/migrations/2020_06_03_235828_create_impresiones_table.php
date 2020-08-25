<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpresionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlconsumibles')->hasTable('impresiones')) 
        {
            Schema::connection('controlconsumibles')->create('impresiones', function (Blueprint $table) {
                $table->bigIncrements('id')->unique();
                $table->integer('id_usuario');
                $table->string('codigo');
                $table->tinyInteger('linea');
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
        Schema::connection('controlconsumibles')->dropIfExists('devoluciones');
    }
}
