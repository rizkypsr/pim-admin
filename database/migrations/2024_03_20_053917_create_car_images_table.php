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
        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->longText('filename');
            $table->bigInteger('car_id')->unsigned();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_images');
    }
};
