<?php

namespace Tests\Feature\Front\Reviews;

use App\Shop\Reviews\Review;
use Tests\TestCase;

class ReviewFeatureTest extends TestCase
{
    /** @test */
    public function a_logged_in_customer_can_submit_a_review()
    {
        $data = [
            'product_id' => $this->product->id,
            'rating' => 'up',
            'comment' => 'Really good quality.',
        ];

        $this
            ->actingAs($this->customer, 'web')
            ->post(route('reviews.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas('message', 'Thank you for your review!');

        $this->assertDatabaseHas('reviews', [
            'product_id' => $this->product->id,
            'customer_id' => $this->customer->id,
            'comment' => 'Really good quality.',
        ]);
    }

    /** @test */
    public function a_guest_cannot_submit_a_review()
    {
        $data = [
            'product_id' => $this->product->id,
            'rating' => 'up',
            'comment' => 'Nice.',
        ];

        $this
            ->post(route('reviews.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_cannot_submit_a_review_twice_for_the_same_product()
    {
        $data = [
            'product_id' => $this->product->id,
            'rating' => 'up',
            'comment' => 'Nice.',
        ];

        $this->actingAs($this->customer, 'web')->post(route('reviews.store'), $data);

        $this
            ->actingAs($this->customer, 'web')
            ->post(route('reviews.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas('error');

        $this->assertEquals(1, Review::where('product_id', $this->product->id)->count());
    }

    /** @test */
    public function the_product_page_shows_the_review_and_the_thumbs_count()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->post(route('reviews.store'), [
                'product_id' => $this->product->id,
                'rating' => 'up',
                'comment' => 'Solid purchase.',
            ]);

        $this
            ->get(route('front.get.product', $this->product->slug))
            ->assertStatus(200)
            ->assertSee('Solid purchase.');
    }
}
