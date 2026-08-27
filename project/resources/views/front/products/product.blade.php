@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="product"/>
    <meta property="og:title" content="{{ $product->name }}"/>
    <meta property="og:description" content="{{ strip_tags($product->description) }}"/>
    @if(!is_null($product->cover))
        <meta property="og:image" content="{{ asset("storage/$product->cover") }}"/>
    @endif
@endsection

@section('content')
    <div class="container product">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fa fa-home"></i> ホーム</a></li>
                    @if(isset($category))
                    <li class="breadcrumb-item"><a href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">商品詳細</li>
                </ol>
            </div>
        </div>
        @include('layouts.front.product')

        <div class="row">
            <div class="col-md-12 reviews">
                <hr>
                <h3><i class="fa fa-comments"></i> Reviews
                    <small>
                        <i class="fa fa-thumbs-up text-success"></i> {{ $reviews->where('rating', 'up')->count() }}
                        &nbsp;
                        <i class="fa fa-thumbs-down text-danger"></i> {{ $reviews->where('rating', 'down')->count() }}
                    </small>
                </h3>

                @auth
                    @if($hasReviewed)
                        <p class="alert alert-info">You have already reviewed this product.</p>
                    @else
                        <form action="{{ route('reviews.store') }}" method="post" class="form">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="rating" value="up" checked>
                                    <i class="fa fa-thumbs-up text-success"></i> Recommend
                                </label>
                                &nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="rating" value="down">
                                    <i class="fa fa-thumbs-down text-danger"></i> Not recommend
                                </label>
                            </div>
                            <div class="form-group">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Share your thoughts about this product" required>{{ old('comment') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit review</button>
                        </form>
                    @endif
                @else
                    <p class="alert alert-warning">
                        <a href="{{ route('login') }}">Log in</a> to leave a review.
                    </p>
                @endauth

                <hr>

                @forelse($reviews as $review)
                    <div class="media">
                        <div class="media-body">
                            <h5 class="media-heading">
                                {{ $review->customer->name ?? 'Customer' }}
                                @if($review->rating === 'up')
                                    <i class="fa fa-thumbs-up text-success"></i>
                                @else
                                    <i class="fa fa-thumbs-down text-danger"></i>
                                @endif
                                <small>{{ $review->created_at->format('Y-m-d') }}</small>
                            </h5>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                    <hr>
                @empty
                    <p>No reviews yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection