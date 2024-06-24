<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'cotizaciones';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'id_producto',
        'id_cliente',
        'fecha_cot',
        'Vigencia',
        'precio',
        'comentarios'
    ];
}
