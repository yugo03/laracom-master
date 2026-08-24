<?php

namespace Tests\Feature\Front\Cart;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Coupons\Coupon;
use Tests\TestCase;

class CartCouponFeatureTest extends TestCase
{
    /** @test */
    public function it_applies_a_valid_coupon_and_reduces_the_total()
    {
        $coupon = factory(Coupon::class)->create([
            'code' => 'SAVE5',
            'type' => Coupon::TYPE_FIXED,
            'value' => 5,
        ]);

        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        $this
            ->post(route('cart.coupon.store'), ['code' => $coupon->code])
            ->assertStatus(302)
            ->assertSessionHas('message', 'Coupon applied successfully!')
            ->assertRedirect(route('cart.index'));

        $this
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee('SAVE5');
    }

    /** @test */
    public function it_errors_when_the_coupon_code_does_not_exist()
    {
        $this
            ->post(route('cart.coupon.store'), ['code' => 'DOES-NOT-EXIST'])
            ->assertStatus(302)
            ->assertSessionHas('error')
            ->assertRedirect(route('cart.index'));
    }

    /** @test */
    public function it_errors_when_the_coupon_is_expired()
    {
        $coupon = factory(Coupon::class)->create([
            'code' => 'EXPIRED10',
            'expires_at' => now()->subDay(),
        ]);

        $this
            ->post(route('cart.coupon.store'), ['code' => $coupon->code])
            ->assertStatus(302)
            ->assertSessionHas('error')
            ->assertRedirect(route('cart.index'));
    }

    /** @test */
    public function it_can_remove_an_applied_coupon()
    {
        $coupon = factory(Coupon::class)->create(['code' => 'REMOVE-ME']);

        $this->post(route('cart.coupon.store'), ['code' => $coupon->code]);

        $this
            ->delete(route('cart.coupon.destroy'))
            ->assertStatus(302)
            ->assertSessionHas('message', 'Coupon removed.')
            ->assertRedirect(route('cart.index'));

        $cartRepo = new CartRepository(new ShoppingCart);
        $this->assertNull($cartRepo->getAppliedCoupon());
    }
}
