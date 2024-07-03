<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence(2),
            'descripcion_corta' => $this->faker->paragraph,
            'descripcion_larga' => $this->faker->paragraph,
            'precio' => $this->faker->randomFloat(2, 10, 100),
            'categoria_id' => \App\Models\Categoria::factory(), // Relacionar con una categoría
        ];
    }
}
