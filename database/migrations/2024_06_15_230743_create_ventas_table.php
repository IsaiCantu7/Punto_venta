<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vendedor');
            $table->unsignedBigInteger('Id_producto');
            $table->unsignedBigInteger('id_cat');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_pago');
            $table->date('Fecha_de_venta');
            $table->string('motivo');
            $table->decimal('Cambio', 8, 2);
            $table->decimal('Subtotal', 8, 2);
            $table->decimal('IVA', 8, 2);
            $table->decimal('Total', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
