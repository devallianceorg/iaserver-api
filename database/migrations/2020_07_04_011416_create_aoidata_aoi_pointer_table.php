<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoidataAoiPointerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('aoi_pointer')) 
        {
            Schema::connection('aoidata')->create('aoi_pointer', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('date');
                $table->time('time');
                $table->datetime('pointer');
                $table->timestamp('created_at');
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
        Schema::connection('aoidata')->dropIfExists('aoi_pointer');
    }
}
