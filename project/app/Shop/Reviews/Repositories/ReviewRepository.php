<?php

namespace App\Shop\Reviews\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Products\Product;
use App\Shop\Reviews\Exceptions\CreateReviewErrorException;
use App\Shop\Reviews\Exceptions\ReviewAlreadyExistsException;
use App\Shop\Reviews\Exceptions\ReviewNotFoundException;
use App\Shop\Reviews\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    /**
     * ReviewRepository constructor.
     *
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        parent::__construct($review);
        $this->model = $review;
    }

    /**
     * @param array $data
     *
     * @return Review
     * @throws CreateReviewErrorException
     * @throws ReviewAlreadyExistsException
     */
    public function createReview(array $data) : Review
    {
        if ($this->customerHasReviewedProduct(Product::findOrFail($data['product_id']), $data['customer_id'])) {
            throw new ReviewAlreadyExistsException('You have already reviewed this product.');
        }

        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateReviewErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Review
     * @throws ReviewNotFoundException
     */
    public function findReviewById(int $id) : Review
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ReviewNotFoundException($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteReview() : bool
    {
        return $this->delete();
    }

    /**
     * @param Product $product
     *
     * @return Collection
     */
    public function listReviewsForProduct(Product $product) : Collection
    {
        return $product->reviews()->with('customer')->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param Product $product
     * @param int $customerId
     *
     * @return bool
     */
    public function customerHasReviewedProduct(Product $product, int $customerId) : bool
    {
        return $product->reviews()->where('customer_id', $customerId)->exists();
    }
}
