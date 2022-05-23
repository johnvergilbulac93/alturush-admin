<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_tenants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bunit_code');
            $table->string('tenant');
            $table->string('acroname')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('additional_charge')->nullable();
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
        Schema::dropIfExists('gc_tenants');
    }
}
