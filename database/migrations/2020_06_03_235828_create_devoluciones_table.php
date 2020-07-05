<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlconsumibles')->hasTable('devoluciones')) 
        {
            Schema::connection('controlconsumibles')->create('devoluciones', function (Blueprint $table) {
                $table->bigIncrements('id')->unique();
                $table->string('codigo',45);
                $table->string('operador',45);
                $table->tinyInteger('linea');
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
        Schema::connection('controlconsumibles')->dropIfExists('devoluciones');
    }
}
