<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWipOt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('sqlebs')->hasTable('XXE_WIP_OT')) 
        {
            Schema::connection('sqlebs')->create('XXE_WIP_OT', function (Blueprint $table) {
                $table->string('NRO_OP',30);
                $table->integer('NRO_INFORME');
                $table->string("CODIGO_PRODUCTO",50);
                $table->integer("CANTIDAD");
                $table->string("REFERENCIA_1",30);
                $table->tinyInteger("TRANS_OK");
                $table->string("EBS_ERROR_DESC",100);
                $table->string("EBS_ERROR_TRANS",100);
                $table->datetime('FECHA_PROCESO');
                $table->timestamp('FECHA_INSERCION');
                $table->string('ORGANIZATION_CODE',3);                
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
        Schema::connection('sqlebs')->dropIfExists('XXE_WIP_OT');
    }
}
