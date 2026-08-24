<?php

namespace App\Http\Controllers\Front;

use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Reviews\Repositories\ReviewRepositoryInterface;

class ProductController extends Controller
{
    use ProductTransformable;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var ReviewRepositoryInterface
     */
    private $reviewRepo;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository, ReviewRepositoryInterface $reviewRepository)
    {
        $this->productRepo = $productRepository;
        $this->reviewRepo = $reviewRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $list = $this->productRepo->searchProduct(request()->input('q'));

        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), 10)
        ]);
    }

    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $product = $this->transformProduct($product);
        $images = $product->images()->get();
        $category = $product->categories()->first();
        $productAttributes = $product->attributes;

        $reviews = $this->reviewRepo->listReviewsForProduct($product);
        $hasReviewed = auth()->check()
            ? $this->reviewRepo->customerHasReviewedProduct($product, auth()->id())
            : false;

        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category',
            'reviews',
            'hasReviewed'
        ));
    }
}
