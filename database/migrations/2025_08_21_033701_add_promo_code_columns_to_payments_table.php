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
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('has_promo_code')->default(false)->after('verified_by');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->onDelete('set null')->after('has_promo_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropColumn(['has_promo_code', 'promo_code_id']);
        });
    }
};
