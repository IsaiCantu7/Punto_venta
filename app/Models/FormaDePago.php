<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePago extends Model
{
    use HasFactory;

    protected $table = 'forma_de_pago';
    protected $fillable = ['tipo'];
}
