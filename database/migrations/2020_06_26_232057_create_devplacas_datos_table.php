<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevplacasDatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('datos')) 
        {
            Schema::connection('controlplacas')->create('datos', function (Blueprint $table) {
                $table->bigIncrements('id')->unique();
                $table->string('modelo');
                $table->string('lote');
                $table->string('placa');
                $table->integer('cantidad');
                $table->date('fecha',0);
                $table->time('hora',0);
                $table->tinyInteger('ebs');
                $table->integer('id_turno');
                $table->integer('id_sector');
                $table->integer('id_destino');
                $table->string('op');
                $table->text('stocker');
                $table->string('semielaborado');
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
        Schema::connection('controlplacas')->dropIfExists('datos');
    }
}
