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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_reference')->unique();
            $table->foreignId('booking_id')->constrained('rides_bookings')->onDelete('cascade');
            $table->enum('booking_type', ['ride', 'air_taxi', 'tour'])->default('ride');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer', 'gateway', 'cash'])->default('bank_transfer');
            $table->enum('payment_type', ['partial', 'full', 'refund']);
            $table->string('reference_number')->nullable();
            $table->string('payment_slip_path')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
