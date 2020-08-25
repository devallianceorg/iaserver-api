<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoidataCuarentenaPointerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('cuarentena_pointer')) 
        {
            Schema::connection('aoidata')->create('cuarentena_pointer', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('op');
                $table->integer('id_user_calidad');
                $table->text('motivo');
                $table->enum('tipo', ['CODE', 'OP', 'AOI']);
                $table->integer('id_maquina');
                $table->datetime('pointer');
                $table->date('date');
                $table->time('time');
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
        Schema::connection('aoidata')->dropIfExists('cuarentena_pointer');
    }
}
