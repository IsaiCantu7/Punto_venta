<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_vendedor');
            $table->date('fecha_cot');
            $table->date('vigencia');
            $table->decimal('subtotal', 10, 2); // Nuevo campo para subtotal
            $table->decimal('iva', 10, 2); // Nuevo campo para IVA
            $table->decimal('total', 10, 2); // Nuevo campo para total
            $table->text('comentarios')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};
