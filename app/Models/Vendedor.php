<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'vendedores';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'nombre',
        'correo',
        'telefono'
    ];
    // Relación uno a muchos con la tabla de cotizaciones
    public function cotizaciones() {
        return $this->hasMany(Cotizacion::class, 'id_vendedor');
    }
}
