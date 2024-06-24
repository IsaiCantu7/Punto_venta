<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'clientes';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'Nombre',
        'correo',
        'telefono',
        'Dirección',
        'RFC',
        'Razon_social',
        'Codigo_postal',
        'Regimen_fiscal'
    ];
}
