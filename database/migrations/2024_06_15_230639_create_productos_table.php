<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('categoria_id');
            $table->decimal('PV', 8, 2);
            $table->decimal('PC', 8, 2);
            $table->date('Fecha_de_compra');
            $table->integer('cantidad');
            $table->string('Color(es)')->nullable();
            $table->text('descripcion_corta');
            $table->text('descripcion_larga');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
