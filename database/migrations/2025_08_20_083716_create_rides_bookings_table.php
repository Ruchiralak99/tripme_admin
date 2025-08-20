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
        Schema::create('rides_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('ride_cities')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('quantity');
            $table->json('passengers'); // Store array of passenger details
            $table->decimal('base_price', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('promo_discount', 10, 2)->default(0);
            $table->decimal('full_payment_discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_type', ['tentative', 'partial', 'full']);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->string('promo_code')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->timestamp('preferred_date')->nullable();
            $table->timestamp('confirmed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides_bookings');
    }
};
