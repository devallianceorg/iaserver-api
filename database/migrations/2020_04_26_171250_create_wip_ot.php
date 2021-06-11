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
                $table->bigIncrements('ID');
                $table->string('ORGANIZATION_CODE',3);                
                $table->string('WIP_ENTITY_NAME',30);
                $table->integer("START_QUANTITY");
                $table->integer("QUANTITY_COMPLETED");
                $table->string("ALTERNATE_BOM_DESIGNATOR");
                $table->integer("PRIMARY_ITEM_ID");
                $table->string("SEGMENT1");
                $table->string("DESCRIPTION");
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
        Schema::connection('sqlebs')->dropIfExists('XXE_WIP_OT');
    }
}
