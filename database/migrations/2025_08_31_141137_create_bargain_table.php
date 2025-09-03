<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bargains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('username')->unique();
            $table->string('profile_image')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('registration_number')->unique();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('address')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->integer('edit_frequent')->default(0);
            $table->enum('status', ['one-time', 'more-time'])->default('one-time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bargains');
    }
};
