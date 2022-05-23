<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcSetupBusinessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_setup_business_rules', function (Blueprint $table) {

            $table->id('rule_id');
            $table->decimal('minimum_order_amount',10,2);
            $table->decimal('pickup_charge',10,2);
            $table->time('ordering_cutoff_time');
            $table->time('serving_time_start');
            $table->time('serving_time_end');
            $table->integer('maximum_no_of_orders')->nullable();
            $table->integer('advance_ordering_maximum_days_allowed');
            $table->time('advance_ordering_cutoff_date');
            $table->time('advance_ordering_cutoff_time');
            $table->time('pickup_cutoff_time_customer');

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
        Schema::dropIfExists('gc_setup_business_rules');
    }
}
