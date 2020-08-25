<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoidataCuarentenaDetalleTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('cuarentena_detalle_test')) 
        {
            Schema::connection('aoidata')->create('cuarentena_detalle_test', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_cuarentena');
                $table->string('barcode');
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
        Schema::connection('aoidata')->dropIfExists('cuarentena_detalle_test');
    }
}
