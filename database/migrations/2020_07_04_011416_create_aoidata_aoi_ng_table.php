<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoidataAoiNgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('aoidata')->hasTable('aoi_ng')) 
        {
            Schema::connection('aoidata')->create('aoi_ng', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_maquina');
                $table->string('panel_barcode');
                $table->date('date');
                $table->time('time');
                $table->datetime('created_at');
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
        Schema::connection('aoidata')->dropIfExists('aoi_ng');
    }
}
