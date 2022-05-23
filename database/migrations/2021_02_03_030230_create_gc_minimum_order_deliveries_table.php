<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcMinimumOrderDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_minimum_order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('bunit_code');
            $table->tinyInteger('tenant_id');
            $table->tinyInteger('department_id');
            $table->decimal('amount');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('gc_minimum_order_deliveries');
    }
}
