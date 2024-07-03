<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'id_proveedor', 'Fecha_de_compra', 'precio_total', 'descuento', 'efectivo', 'cambio', 
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compra_producto', 'compra_id', 'producto_id')
                    ->withPivot('cantidad', 'precio_unitario');
    }
}
