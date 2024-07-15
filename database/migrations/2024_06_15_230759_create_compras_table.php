<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proveedor');
            $table->date('Fecha_de_compra');
            $table->decimal('total', 8, 2);
            $table->decimal('descuento', 8, 2)->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
