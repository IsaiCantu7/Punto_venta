<?php

namespace Database\Seeders;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

                // Crear una categoría
                $categoria = Categoria::factory()->create();

                // Crear un proveedor
                $proveedor = Proveedor::factory()->create();
        
                // Crear un producto asociado a la categoría y al proveedor
                Producto::factory()->create([
                    'categoria_id' => $categoria->id,
                    'proveedor_id' => $proveedor->id,
                ]);
    }
}
