<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePago extends Model
{
    use HasFactory;
    // Definir la tabla de la base de datos
    protected $table = 'forma_de_pago';
    // Definir los campos que se pueden llenar
    protected $fillable = [
        'tipo'
    ];
}
