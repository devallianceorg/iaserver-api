<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoidataCuarentenaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('cuarentena')) 
        {
            Schema::connection('aoidata')->create('cuarentena', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_user_calidad');
                $table->text('motivo');
                $table->enum('tipo', ['CODE', 'OP', 'AOI']);
                $table->integer('id_maquina');
                $table->string('op');
                $table->datetime('created_at');
                $table->datetime('updated_at');
                $table->datetime('released_at');
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
        Schema::connection('aoidata')->dropIfExists('cuarentena');
    }
}
