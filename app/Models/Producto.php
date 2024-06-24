<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'productos';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'nombre',
        'categoria_id',
        'PV',
        'PC',
        'Fecha_de_compra',
        'Color(es)',
        'descripcion_corta',
        'descripcion_larga'
    ];

    // Relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
