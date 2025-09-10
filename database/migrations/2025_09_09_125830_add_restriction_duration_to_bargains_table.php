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
        Schema::table('bargains', function (Blueprint $table) {
            $table->timestamp('restriction_starts_at')->nullable()->after('restriction_count');
            $table->timestamp('restriction_ends_at')->nullable()->after('restriction_starts_at');
            $table->integer('restriction_duration_days')->nullable()->after('restriction_ends_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bargains', function (Blueprint $table) {
            $table->dropColumn(['restriction_starts_at', 'restriction_ends_at', 'restriction_duration_days']);
        });
    }
};
