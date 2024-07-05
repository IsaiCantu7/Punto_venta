<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->date('Fecha_de_venta');
            $table->decimal('precio_total', 8, 2)->nullable();
            $table->decimal('iva', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('efectivo', 8, 2);
            $table->decimal('cambio', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
