<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PromoCode;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromoCode::create([
            'code' => 'WELCOME20',
            'description' => 'Welcome discount for new customers - 20% off on first booking',
            'author' => 'Marketing Team',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'minimum_amount' => 50,
            'maximum_discount' => 100,
            'usage_limit' => 100,
            'valid_from' => '2025-08-20',
            'valid_until' => '2025-12-31',
            'status' => 'active'
        ]);

        PromoCode::create([
            'code' => 'SAVE50',
            'description' => 'Fixed $50 discount on helicopter rides',
            'author' => 'Sales Team',
            'discount_type' => 'fixed',
            'discount_value' => 50,
            'minimum_amount' => 200,
            'maximum_discount' => null,
            'usage_limit' => 50,
            'valid_from' => '2025-08-20',
            'valid_until' => '2025-11-30',
            'status' => 'active'
        ]);

        PromoCode::create([
            'code' => 'EARLYBIRD',
            'description' => 'Early bird special - 15% off for advance bookings',
            'author' => 'John Manager',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'minimum_amount' => 100,
            'maximum_discount' => 75,
            'usage_limit' => null,
            'valid_from' => '2025-08-20',
            'valid_until' => '2025-10-31',
            'status' => 'active'
        ]);

        PromoCode::create([
            'code' => 'EXPIRED10',
            'description' => 'Test expired promo code',
            'author' => 'Admin',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'minimum_amount' => 25,
            'maximum_discount' => 50,
            'usage_limit' => 20,
            'valid_from' => '2025-07-01',
            'valid_until' => '2025-07-31',
            'status' => 'active'
        ]);

        PromoCode::create([
            'code' => 'INACTIVE25',
            'description' => 'Test inactive promo code',
            'author' => null,
            'discount_type' => 'percentage',
            'discount_value' => 25,
            'minimum_amount' => 75,
            'maximum_discount' => 125,
            'usage_limit' => 30,
            'valid_from' => '2025-08-20',
            'valid_until' => '2025-12-31',
            'status' => 'inactive'
        ]);
    }
}
