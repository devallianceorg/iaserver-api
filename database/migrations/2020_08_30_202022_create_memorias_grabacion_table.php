<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasGrabacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('grabacion')) 
        {
            Schema::connection('memorias')->create('grabacion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('cantidad');
                $table->string('color');
                $table->string('referencia');
                $table->string('semielaborad');
                $table->string('firmware');
                $table->string('material');
                $table->string('op');
                $table->integer('id_programador');
                $table->integer('id_usuario');
                $table->integer('id_traza');
                $table->integer('traza_code');
                $table->string('traza_det');
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
        Schema::connection('memorias')->dropIfExists('grabacion');
    }
}
