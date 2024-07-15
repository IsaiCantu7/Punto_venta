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
    public function cotizaciones()
{
    return $this->belongsToMany(Cotizacion::class, 'cotizacion_producto', 'producto_id', 'cotizacion_id')
        ->withTimestamps();
}

public function compras()
{
    return $this->belongsToMany(Compra::class, 'compra_producto')
                ->withPivot('cantidad', 'precio')
                ->withTimestamps();
}
public function ventas()
{
    return $this->belongsToMany(Venta::class, 'venta_producto')
                ->withPivot('cantidad', 'precio_unitario');
}

public function inventarios()
{
    return $this->hasMany(Inventario::class, 'producto_id');

}
}
