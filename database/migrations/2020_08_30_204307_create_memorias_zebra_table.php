<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasZebraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('memorias')->hasTable('zebra')) 
        {
            Schema::connection('memorias')->create('zebra', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('impresora_ip');
                $table->smallInteger('impresora_port');
                $table->string('prn');
                $table->string('ebs');
                $table->timestamps();
                
                $table->unique('name');
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
        Schema::connection('memorias')->dropIfExists('zebra');
    }
}
