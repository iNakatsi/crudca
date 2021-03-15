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
            $table->string('endereco', 250);
            $table->string('coordenada0', 50);
            $table->string('coordenada1', 50);
            $table->string('nome', 120);
            $table->string('atividade', 50);
            $table->string('contato', 50);
            $table->date('data_pedido');
            $table->string('observacao', 400)->nullable();
            $table->string('andamento', 50);
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
