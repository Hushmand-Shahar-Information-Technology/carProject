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
        if (!Schema::hasTable('seller_profiles')) {
            Schema::create('seller_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('username');
                $table->string('profile_image')->nullable();
                $table->string('address');
                $table->string('registration_number');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};