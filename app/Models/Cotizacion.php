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
        'id_cliente',
        'id_vendedor',
        'fecha_cot',
        'vigencia',
        'comentarios',
        'subtotal',
        'iva',
        'total',
    ];
    

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'cotizacion_producto', 'cotizacion_id', 'producto_id')
            ->withPivot('cantidad', 'precio') 
            ->withTimestamps(); 
    }
    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con el vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'id_vendedor');
    }
}
