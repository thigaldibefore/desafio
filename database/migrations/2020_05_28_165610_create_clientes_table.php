<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('nome', 255);
            $table->string('documento', 255);
            $table->string('email', 255);
            $table->string('telefone', 255);
            $table->string('celular', 255);
            $table->string('cep', 255);
            $table->string('estado', 255);
            $table->string('cidade', 255);
            $table->string('bairro', 255);
            $table->string('rua', 255);
            $table->string('numero', 255);
            $table->string('complemento', 255);
            $table->enum('tipo', ['F', 'J'])->default('J');
            $table->enum('mensalista', ['1', '0'])->default('0');
            $table->enum('status', ['1', '0'])->default('0');
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
        Schema::dropIfExists('clientes');
    }
}
