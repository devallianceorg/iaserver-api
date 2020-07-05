<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlconsumibles')->hasTable('egresos')) 
        {
            Schema::connection('controlconsumibles')->create('egresos', function (Blueprint $table) {
                $table->bigIncrements('id')->unique();
                $table->string('codigo');
                $table->integer('consumible_id');
                $table->string('lote');
                $table->integer('operador_id');
                $table->integer('linea_id');
                $table->tinyInteger('status');
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
        Schema::connection('controlconsumibles')->dropIfExists('egresos');
    }
}
