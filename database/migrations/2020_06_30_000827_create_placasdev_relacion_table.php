<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasdevRelacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('controlplacas')->hasTable('relacion')) 
        {
            Schema::connection('controlplacas')->create('relacion', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codigo');
                $table->string('pcb',100);
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
        Schema::connection('controlplacas')->dropIfExists('relacion');
    }
}
