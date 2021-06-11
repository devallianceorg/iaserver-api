<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IaserverDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('iaserver')->hasTable('failed_jobs')) 
        {
            Schema::connection('iaserver')->create('failed_jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->timestamp('failed_at');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('jobs')) 
        {
            Schema::connection('iaserver')->create('jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('queue');
                $table->longText('payload');
                $table->tinyInteger('attempts');
                $table->tinyInteger('reserved');
                $table->integer('reserved_at');
                $table->integer('available_at');
                $table->integer('created_at');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('menu')) 
        {
            Schema::connection('iaserver')->create('menu', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('titulo');
                $table->text('link');
                $table->integer('root');
                $table->string('icono');
                $table->string('permiso');
                $table->enum('type',['route','link','self','blank'])->default(null);
                $table->text('enlace');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('migrations')) 
        {
            Schema::connection('iaserver')->create('migrations', function (Blueprint $table) {
                $table->string('migration');
                $table->integer('batch');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('password_resets')) 
        {
            Schema::connection('iaserver')->create('password_resets', function (Blueprint $table) {
                $table->string('email');
                $table->string('token');
                $table->timestamp('created_at');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('permission_role')) 
        {
            Schema::connection('iaserver')->create('permission_role', function (Blueprint $table) {
                $table->integer('permission_id');
                $table->integer('role_id');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('permissions')) 
        {
            Schema::connection('iaserver')->create('permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('display_name');
                $table->string('description');
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('profile')) 
        {
            Schema::connection('iaserver')->create('profile', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->string('apellido');
                $table->string('dni');
                $table->string('legajo');
                $table->integer('user_id');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('role_user')) 
        {
            Schema::connection('iaserver')->create('role_user', function (Blueprint $table) {
                $table->integer('user_id');
                $table->integer('role_id');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('roles')) 
        {
            Schema::connection('iaserver')->create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('display_name');
                $table->string('description');
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
            });
        }

        if (!Schema::connection('iaserver')->hasTable('users')) 
        {
            Schema::connection('iaserver')->create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('password');
                $table->string('remember_token');
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
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
        Schema::connection('iaserver')->dropIfExists('failed_jobs');
        Schema::connection('iaserver')->dropIfExists('jobs');
        Schema::connection('iaserver')->dropIfExists('type');
        Schema::connection('iaserver')->dropIfExists('migrations');
        Schema::connection('iaserver')->dropIfExists('password_resets');
        Schema::connection('iaserver')->dropIfExists('permission_role');
        Schema::connection('iaserver')->dropIfExists('permissions');
        Schema::connection('iaserver')->dropIfExists('profile');
        Schema::connection('iaserver')->dropIfExists('role_user');
        Schema::connection('iaserver')->dropIfExists('roles');
        Schema::connection('iaserver')->dropIfExists('users');
    }
}
