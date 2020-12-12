<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasZocaloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('zocalo')) 
        {
            Schema::connection('memorias')->create('zocalo', function (Blueprint $table) {
                $table->bigIncrements('id_zocalo');
                $table->integer('numero');
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
        Schema::connection('memorias')->dropIfExists('zocalo');
    }
}
