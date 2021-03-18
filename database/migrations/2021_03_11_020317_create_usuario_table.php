<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('endereco');
            $table->string('coordenada0');
            $table->string('coordenada1');
            $table->string('nome');
            $table->string('atividade');
            $table->string('contato');
            $table->date('data_pedido');
            $table->date('data_finalizado')->nullable();
            $table->string('observacao')->nullable();
            $table->string('andamento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
