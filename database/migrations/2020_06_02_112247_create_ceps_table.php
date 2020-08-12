<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function Ramsey\Uuid\v1;

class CreateCepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceps', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('id');
            $table->unsignedInteger('cidade_id'. false)->nullable()->references('id')->on('cidades');
            $table->string('cep', 11)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('nome_logradouro', 100)->nullable();
            $table->string('logradouro', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('grandes_usuarios', 100)->nullable();
            $table->string('tipo_sem_acento', 50)->nullable();
            $table->string('nome_logradouro_sem_acento', 100)->nullable();
            $table->string('logradouro_sem_acento', 100)->nullable();
            $table->string('bairro_sem_acento', 100)->nullable();
            $table->string('cidade_sem_acento', 100)->nullable();
            $table->string('complemento_sem_acento', 100)->nullable();
            $table->string('grandes_usuarios_sem_acento', 100)->nullable();
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('cidade_ibge', 20)->nullable();
            $table->string('cidade_area', 20)->nullable();
            $table->string('ddd', 2)->nullable();
            $table->string('cep_ativo', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voids
     */
    public function down()
    {
        Schema::dropIfExists('ceps');
    }
}
