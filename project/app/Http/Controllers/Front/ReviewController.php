<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Reviews\Exceptions\ReviewAlreadyExistsException;
use App\Shop\Reviews\Repositories\ReviewRepository;
use App\Shop\Reviews\Repositories\ReviewRepositoryInterface;
use App\Shop\Reviews\Requests\CreateReviewRequest;

class ReviewController extends Controller
{
    /**
     * @var ReviewRepositoryInterface
     */
    private $reviewRepo;

    /**
     * ReviewController constructor.
     *
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepo = $reviewRepository;
    }

    /**
     * @param CreateReviewRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateReviewRequest $request)
    {
        try {
            $this->reviewRepo->createReview([
                'product_id' => $request->input('product_id'),
                'customer_id' => auth()->id(),
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]);

            return back()->with('message', 'Thank you for your review!');
        } catch (ReviewAlreadyExistsException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $review = $this->reviewRepo->findReviewById($id);

        if ($review->customer_id !== auth()->id()) {
            abort(403);
        }

        $reviewRepo = new ReviewRepository($review);
        $reviewRepo->deleteReview();

        return back()->with('message', 'Review deleted.');
    }
}
