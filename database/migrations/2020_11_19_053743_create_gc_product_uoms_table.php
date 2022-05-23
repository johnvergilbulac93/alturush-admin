<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcProductUomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_product_uoms', function (Blueprint $table) {
            $table->id('uom_id');
            $table->integer('itemcode')->unsigned();
            $table->string('UOM');
            $table->integer('qty_per_uom')->unsigned();
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
        Schema::dropIfExists('gc_product_uoms');
    }
}
