<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'ventas';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'id_vendedor',
        'Id_producto',
        'id_cat',
        'id_cliente',
        'id_pago',
        'Fecha_de_venta',
        'motivo',
        'Cambio',
        'Subtotal',
        'IVA',
        'Total'
    ];
}

