<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtdatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('smtdatabase')->hasTable('ingenieria'))
        {
            Schema::connection('smtdatabase')->create('ingenieria', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('modelo');
                $table->string('lote');
                $table->string('hash');
                // $table->dateTime('fecha_modificacion'); // <-- no hace falta porque se agregan Timestamps()
                $table->integer('version');
                $table->timestamps();
            });
        }

        if (!Schema::connection('smtdatabase')->hasTable('lotes'))
        {
            Schema::connection('smtdatabase')->create('lotes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_ingenieria');
                $table->integer('id_ver');
                $table->string('bom');
                $table->string('descripcion');
                $table->string('lote_version');
                $table->string('item_num');
                $table->string('logop');
                $table->string('posicion');
                $table->string('componente');
                $table->string('descripcion_componente');
                $table->string('cantidad');
                $table->string('unidad_medida');
                $table->string('asignacion');
                $table->string('fecha');
                $table->string('subinventario');
                $table->string('localizador');
                $table->string('tipo_material');
                $table->string('kit');
                $table->string('placa');
                $table->string('sustituto');
                $table->string('item_cygnus');
                $table->string('item_type');
                $table->timestamps();

                $table->foreign('id_ingenieria')->references('id')->on('ingenieria');
            });
        }

        if (!Schema::connection('smtdatabase')->hasTable('materiales'))
        {
            Schema::connection('smtdatabase')->create('materiales', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('logop');
                $table->string('componente');
                $table->string('descripcion_componente');
                $table->string('asignacion');
                $table->string('item_cygnus');
                $table->tinyInteger('pcb');
                $table->timestamps();
            });
        }

        if (!Schema::connection('smtdatabase')->hasTable('material_index'))
        {
            Schema::connection('smtdatabase')->create('material_index', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_ingenieria');
                $table->bigInteger('id_material');
                $table->timestamps();

                $table->foreign('id_ingenieria')->references('id')->on('ingenieria');
                $table->foreign('id_material')->references('id')->on('materiales');
            });
        }

        if (!Schema::connection('smtdatabase')->hasTable('new_production_target'))
        {
            Schema::connection('smtdatabase')->create('new_production_target', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('linea');
                $table->integer('target');
                $table->timestamps();
            });
        }

        if (!Schema::connection('smtdatabase')->hasTable('orden_trabajo'))
        {
            Schema::connection('smtdatabase')->create('orden_trabajo', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('op');
                $table->string('modelo');
                $table->string('lote');
                $table->string('panel');
                $table->integer('prod_aoi');
                $table->integer('prod_man');
                $table->integer('qty');
                $table->string('semielaborado');
                $table->timestamps();
            });
        }

        // FALTA AGREGAR
        if (!Schema::connection('smtdatabase')->hasTable('production_target'))
        {
            Schema::connection('smtdatabase')->create('production_target', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_orden_trabajo');
                $table->string('target');
                $table->timestamps();

                $table->foreign('id_orden_trabajo')->references('id')->on('orden_trabajo');
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
        Schema::connection('smtdatabase')->dropIfExists('ingenieria');
        Schema::connection('smtdatabase')->dropIfExists('lotes');
        Schema::connection('smtdatabase')->dropIfExists('material_index');
        Schema::connection('smtdatabase')->dropIfExists('materiales');
        Schema::connection('smtdatabase')->dropIfExists('new_production_target');
        Schema::connection('smtdatabase')->dropIfExists('orden_trabajo');
        Schema::connection('smtdatabase')->dropIfExists('production_target');
    }
}
