<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('name', 255);
            $table->string('login', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('avatar', 255);
            $table->enum('status', ['1', '0'])->default('0');
            $table->enum('editado', ['1', '0'])->default('0');
            $table->enum('nivel', ['1', '2'])->default('2');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
