<?php

namespace App\Shop\Reviews\Repositories;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Reviews\Review;
use Illuminate\Support\Collection;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function createReview(array $data) : Review;

    public function findReviewById(int $id) : Review;

    public function deleteReview() : bool;

    public function listReviewsForProduct(Product $product) : Collection;

    public function customerHasReviewedProduct(Product $product, int $customerId) : bool;
}
