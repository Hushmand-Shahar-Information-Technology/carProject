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
        // Drop the existing table if it exists with the wrong structure
        Schema::dropIfExists('bargains');
        
        // Create the correct bargains table structure
        Schema::create('bargains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id'); // references users.id of car_seller
            $table->unsignedBigInteger('seeker_id')->nullable(); // when a seeker engages
            $table->text('details')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->enum('status', ['open','negotiation','closed'])->default('open');
            $table->timestamps();
            
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seeker_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bargains');
    }
};