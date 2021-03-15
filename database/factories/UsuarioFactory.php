<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'endereco' => $this->faker->name,
            'coordenada0' => $this->faker->name,
            'coordenada1' => $this->faker->name,
            'nome' => $this->faker->name,
            'atividade' => $this->faker->name,
            'data_pedido' => $this->faker->date,
            'observacao' => $this->faker->name,
            'andamento' => $this->faker->name,
            'contato' => $this->faker->name
        ];
    }
}
