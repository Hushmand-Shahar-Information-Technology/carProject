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
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('seller_name');
            $table->string('phone');
            $table->string('car_make')->nullable();
            $table->string('car_model')->nullable();
            $table->integer('car_year')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('vin')->nullable();
            $table->json('car_photos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};