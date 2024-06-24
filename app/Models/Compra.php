<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'compras';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'id_proveedor',
        'id_producto',
        'Fecha_de_compra',
        'precio',
        'cantidad',
        'descuento'
    ];
}
