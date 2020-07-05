<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransOkDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('sqlebs')->hasTable('Trans_Ok_Det')) 
        {
            Schema::connection('sqlebs')->create('Trans_Ok_det', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('description');
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
        Schema::connection('sqlebs')->dropIfExists('Trans_Ok_det');
    }
}
