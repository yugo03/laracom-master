<?php

namespace Tests\Unit\Coupons;

use App\Shop\Coupons\Coupon;
use Tests\TestCase;

class CouponUnitTest extends TestCase
{
    /** @test */
    public function it_is_valid_when_active_and_not_expired()
    {
        $coupon = factory(Coupon::class)->create([
            'is_active' => true,
            'expires_at' => now()->addDay(),
        ]);

        $this->assertTrue($coupon->isValid());
    }

    /** @test */
    public function it_is_invalid_when_inactive()
    {
        $coupon = factory(Coupon::class)->create(['is_active' => false]);

        $this->assertFalse($coupon->isValid());
    }

    /** @test */
    public function it_is_invalid_when_expired()
    {
        $coupon = factory(Coupon::class)->create([
            'is_active' => true,
            'expires_at' => now()->subDay(),
        ]);

        $this->assertFalse($coupon->isValid());
    }

    /** @test */
    public function it_calculates_a_fixed_discount()
    {
        $coupon = factory(Coupon::class)->create([
            'type' => Coupon::TYPE_FIXED,
            'value' => 15,
        ]);

        $this->assertEquals(15.0, $coupon->calculateDiscount(100));
    }

    /** @test */
    public function it_calculates_a_percentage_discount()
    {
        $coupon = factory(Coupon::class)->create([
            'type' => Coupon::TYPE_PERCENT,
            'value' => 10,
        ]);

        $this->assertEquals(10.0, $coupon->calculateDiscount(100));
    }

    /** @test */
    public function the_discount_never_exceeds_the_subtotal()
    {
        $coupon = factory(Coupon::class)->create([
            'type' => Coupon::TYPE_FIXED,
            'value' => 500,
        ]);

        $this->assertEquals(50.0, $coupon->calculateDiscount(50));
    }
}
