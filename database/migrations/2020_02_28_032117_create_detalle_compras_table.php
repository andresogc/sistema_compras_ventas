<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idcompra')->unsigned();
            $table->foreign('idcompra')->references('id')->on('compras')->onDelete('cascade');
            $table->bigInteger('idproducto')->unsigned();
            $table->foreign('idproducto')->references('id')->on('productos');
            $table->integer('cantidad');
            $table->decimal('precio',11,2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_compras');
    }
}
