<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proveedor');
            $table->date('Fecha_de_compra');
            $table->decimal('precio_total', 8, 2)->nullable();
            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('efectivo', 8, 2);
            $table->decimal('cambio', 8, 2);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
