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
        Schema::table('air_taxi_bookings', function (Blueprint $table) {
            $table->string('start_point')->nullable()->after('tour_type');
            $table->string('end_point')->nullable()->after('start_point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('air_taxi_bookings', function (Blueprint $table) {
            $table->dropColumn(['start_point', 'end_point']);
        });
    }
};
