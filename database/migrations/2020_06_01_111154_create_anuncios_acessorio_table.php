<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnunciosAcessorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncios_acessorio', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements('id');
            $table->string('titulo', 255);
            $table->string('valor', 255);
            $table->longText('descricao');
            $table->enum('patrocinado', ['1', '0']);
            $table->enum('status', ['1', '0']);
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
        Schema::dropIfExists('anuncios_acessorio');
    }
}
