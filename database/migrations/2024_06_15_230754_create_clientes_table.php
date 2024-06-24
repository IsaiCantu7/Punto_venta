<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('correo');
            $table->string('telefono');
            $table->string('Dirección');
            $table->string('RFC');
            $table->string('Razon_social');
            $table->string('Codigo_postal');
            $table->string('Regimen_fiscal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }};
