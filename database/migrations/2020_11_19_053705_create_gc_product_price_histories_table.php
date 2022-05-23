<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcProductPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_product_price_histories', function (Blueprint $table) {
            $table->id('history_id');
            $table->double('present_price');
            $table->double('previous_price');
            $table->date('present_price_date');
            $table->date('previous_price_date');
            $table->integer('itemcode')->unsigned();
            $table->string('UOM');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gc_product_price_histories');
    }
}
