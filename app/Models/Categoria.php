<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre'
    ];

    // Relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id'); // Relación de uno a muchos
    }

    // Relación con los productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id'); // Relación de uno a muchos
    }

    // Relación con el inventario
    public function inventario()
    {
        return $this->hasMany(Inventario::class, 'categoria_id'); // Relación de uno a muchos
    }

}
