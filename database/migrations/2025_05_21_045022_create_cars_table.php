<?php

use App\enum\TransmissionType;
use App\enum\TypeTransmission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('year')->nullable();
            $table->string('make')->nullable();

            $table->json('location')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();

            $table->enum('transmission_type', array_column(TransmissionType::cases(), 'value'))->nullable(); 
            $table->string('VIN_number')->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->boolean('request_price_status')->default(false);
            $table->decimal('request_price', 10, 2)->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
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
