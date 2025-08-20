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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price_lkr', 10, 2); // Price in LKR
            $table->decimal('tax_percentage', 5, 2); // Tax as percentage
            $table->decimal('discount_percentage', 5, 2)->nullable(); // Discount as percentage (optional)
            $table->decimal('regular_value', 10, 2); // Calculated regular value after tax and discount
            $table->string('duration')->nullable(); // Optional duration
            $table->integer('passenger_capacity')->nullable(); // Optional passenger capacity
            $table->string('image_path')->nullable(); // Path to uploaded image
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
