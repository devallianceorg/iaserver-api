<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasProgramadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('programador')) 
        {
            Schema::connection('memorias')->create('programador', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('descripcion');
                $table->tinyInteger('visible');
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
        Schema::connection('memorias')->dropIfExists('programador');
    }
}
