<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id', 'Fecha_de_venta', 'precio_total', 'descuento', 'efectivo', 'cambio',  'iva', 'total'
    ];

    /**
     * Obtener el cliente asociado a la venta.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Obtener los productos asociados a la venta.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_producto')
                    ->withPivot('cantidad', 'precio_unitario');
    }
}
