<?php

namespace Tests\Unit\Reviews;

use App\Shop\Reviews\Exceptions\ReviewAlreadyExistsException;
use App\Shop\Reviews\Repositories\ReviewRepository;
use App\Shop\Reviews\Review;
use Tests\TestCase;

class ReviewUnitTest extends TestCase
{
    /** @test */
    public function it_can_create_a_review()
    {
        $reviewRepo = new ReviewRepository(new Review);

        $review = $reviewRepo->createReview([
            'product_id' => $this->product->id,
            'customer_id' => $this->customer->id,
            'rating' => Review::RATING_UP,
            'comment' => 'Great product!',
        ]);

        $this->assertEquals('Great product!', $review->comment);
        $this->assertEquals(Review::RATING_UP, $review->rating);
    }

    /** @test */
    public function it_prevents_a_customer_from_reviewing_the_same_product_twice()
    {
        $reviewRepo = new ReviewRepository(new Review);

        $reviewRepo->createReview([
            'product_id' => $this->product->id,
            'customer_id' => $this->customer->id,
            'rating' => Review::RATING_UP,
            'comment' => 'First review',
        ]);

        $this->expectException(ReviewAlreadyExistsException::class);

        $reviewRepo->createReview([
            'product_id' => $this->product->id,
            'customer_id' => $this->customer->id,
            'rating' => Review::RATING_DOWN,
            'comment' => 'Second review',
        ]);
    }

    /** @test */
    public function it_lists_reviews_for_a_product()
    {
        $reviewRepo = new ReviewRepository(new Review);

        $reviewRepo->createReview([
            'product_id' => $this->product->id,
            'customer_id' => $this->customer->id,
            'rating' => Review::RATING_UP,
            'comment' => 'Nice!',
        ]);

        $reviews = $reviewRepo->listReviewsForProduct($this->product);

        $this->assertCount(1, $reviews);
        $this->assertEquals('Nice!', $reviews->first()->comment);
    }
}
