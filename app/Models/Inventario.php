<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Inventario extends Model
    {
        use HasFactory;
        // Definir la tabla de la base de datos
        protected $table = 'inventarios';
        // Definir los campos que se pueden llenar
        protected $fillable = [
            'producto_id',
            'categoria_id',
            'fecha_de_entrada',
            'fecha_de_salida',
            'motivo',
            'movimiento',
            'cantidad'
        ];
        // Relación uno a muchos inversa
        public function producto()
        {
            return $this->belongsTo(Producto::class);
        }
        // Relación uno a muchos inversa
        public function categoria()
        {
            return $this->belongsTo(Categoria::class);
        }

    }
