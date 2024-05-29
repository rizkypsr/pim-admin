<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('car_name');
            $table->string('brand_name');
            $table->longText('video')->nullable();
            $table->year('year');
            $table->double('price');
            $table->bigInteger('showroom_id')->unsigned();
            $table->timestamps();

            $table->foreign('showroom_id')->references('id')->on('showrooms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
