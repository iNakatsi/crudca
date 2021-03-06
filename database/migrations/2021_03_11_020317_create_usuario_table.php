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
            $table->string('endereco',70);
            $table->string('coordenada0');
            $table->string('coordenada1');
            $table->string('nome',70);
            $table->string('atividade',20);
            $table->string('contato');
            $table->date('data_pedido')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('data_entrega')->nullable();
            $table->date('data_finalizado')->nullable();
            $table->string('observacao',150)->nullable();
            $table->string('andamento')->default('solicitado');
            $table->string('prioridade',20)->default('normal');
            $table->string('usuario_ad');
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
