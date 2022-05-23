<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_product_items', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->integer('itemcode')->unsigned();
            $table->string('image');
            $table->string('status');
            $table->timestamp('date_uploaded');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gc_product_items');
    }
}
