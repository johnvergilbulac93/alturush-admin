<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_product_prices', function (Blueprint $table) {
            $table->id('price_id');
            $table->integer('itemcode')->unsigned();
            $table->date('date');
            $table->string('UOM');
            $table->integer('price_with_vat')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gc_product_prices');
    }
}
