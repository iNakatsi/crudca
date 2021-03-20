<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = "usuarios";

    protected $fillable = [
      'endereco',
      'coordenada0',
      'coordenada1',
      'nome',
      'atividade',
      'data_pedido',
      'data_entrega',
      'data_finalizado',
      'observacao',
      'andamento',
      'contato',
      'prioridade',
      'usuario_ad'
    ];
}
