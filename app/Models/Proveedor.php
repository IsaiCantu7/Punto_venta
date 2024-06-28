<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'proveedores';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'nombre',
        'nombre_contacto',
        'correo',
        'telefono'
    ];

    // Relación uno a muchos con la tabla de compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_proveedor', 'id');
    }
}
