<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasObservacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('observacion')) 
        {
            Schema::connection('memorias')->create('observacion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_referencia');
                $table->integer('id_usuario');
                $table->text('mensaje');
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
        Schema::connection('memorias')->dropIfExists('observacion');
    }
}
