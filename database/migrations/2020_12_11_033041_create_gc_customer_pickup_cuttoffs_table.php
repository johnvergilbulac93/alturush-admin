<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcCustomerPickupCuttoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_customer_pickup_cuttoffs', function (Blueprint $table) {
            $table->id();
            $table->time('start');
            $table->time('end');
            $table->bigInteger('bunit_code');
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
        Schema::dropIfExists('gc_customer_pickup_cuttoffs');
    }
}
