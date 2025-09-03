<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TransmissionType;
use App\Models\User;
use App\Models\Bargain;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('bargain_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('year')->nullable();
            $table->string('make')->nullable();
            $table->string('body_type')->nullable();
            $table->string('car_condition')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_documents')->nullable();
            $table->string('car_inside_color')->nullable();
            $table->string('VIN_number')->nullable();
            $table->string('location')->nullable();
            $table->string('model')->nullable();
            $table->enum('transmission_type', TransmissionType::values())->nullable();
            $table->string('currency_type')->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            // Sale/Rent options
            $table->boolean('is_for_sale')->default(true);
            $table->boolean('is_for_rent')->default(false);
            // Promotion status
            $table->boolean('is_promoted')->default(false);
            $table->decimal('rent_price_per_day', 10, 2)->nullable();
            $table->decimal('rent_price_per_month', 10, 2)->nullable();
            $table->boolean('request_price_status')->default(false);
            $table->decimal('request_price', 10, 2)->nullable();
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
