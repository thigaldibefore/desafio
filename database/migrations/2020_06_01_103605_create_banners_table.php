<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('nome', 255);    
            $table->unsignedInteger('altura', 15);
            $table->unsignedInteger('largura', 15);
            $table->string('imagem', 255);
            $table->string('imagem_mobile', 255);
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedInteger('clientes_id', false)->references('id')->on('clientes');
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
        Schema::dropIfExists('banners');
    }
}
