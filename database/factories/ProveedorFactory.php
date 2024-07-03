<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company,
            'nombre_contacto' => $this->faker->name,
            'correo' => $this->faker->safeEmail,
            'telefono' => $this->faker->phoneNumber,
        ];
    }
}
