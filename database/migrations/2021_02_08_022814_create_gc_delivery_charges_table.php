<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_delivery_charges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('town_id');
            $table->bigInteger('brgy_id');
            $table->decimal('charge_amt',10,2);
            $table->decimal('customer_to_pay',10,2);
            $table->decimal('fuel_amt',10,2);
            $table->decimal('rider_shared',10,2);
            $table->decimal('admin_fee',10,2);
            $table->decimal('expenses_for_store',10,2);
            $table->bigInteger('status')->default(1);
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
        Schema::dropIfExists('gc_delivery_charges');
    }
}
