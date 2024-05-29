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
        Schema::create('showroom_images', function (Blueprint $table) {
            $table->id();
            $table->longText('filename');
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
        Schema::dropIfExists('showroom_images');
    }
};
