<?php
namespace Database\Seeders;

use App\Shop\Coupons\Coupon;
use Illuminate\Database\Seeder;

class WelcomeCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::firstOrCreate(
            ['code' => 'WELCOME10'],
            [
                'type' => Coupon::TYPE_PERCENT,
                'value' => 10,
                'expires_at' => null,
                'is_active' => true,
                'first_order_only' => true,
            ]
        );
    }
}
