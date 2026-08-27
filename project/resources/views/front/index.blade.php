@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home" />
    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:description" content="{{ config('app.name') }}" />
@endsection

@section('content')
    @include('layouts.front.home-slider')

    <section id="quick-links" class="quick-links-section">
        <div class="container">
            <div class="quick-links-grid">
                <a href="{{ route('search.product') }}" class="quick-link-item">
                    <i class="fa fa-th-large"></i>
                    <span>商品一覧</span>
                </a>
                <a href="{{ route('cart.index') }}" class="quick-link-item">
                    <i class="fa fa-shopping-cart"></i>
                    <span>カートを見る</span>
                </a>
                @auth
                    <a href="{{ route('accounts', ['tab' => 'profile']) }}" class="quick-link-item">
                        <i class="fa fa-user"></i>
                        <span>マイページ</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="quick-link-item">
                        <i class="fa fa-user"></i>
                        <span>ログイン / 会員登録</span>
                    </a>
                @endauth
                <a href="{{ route('contact') }}" class="quick-link-item">
                    <i class="fa fa-envelope"></i>
                    <span>お問い合わせ</span>
                </a>
            </div>
        </div>
    </section>

    @if ($cat1->products->isNotEmpty())
        <section id="collection" class="new-product t100 home">
            <div class="container">
                <div class="section-title b100">
                    <h2>{{ $cat1->name }}</h2>
                </div>
                @include('front.products.product-list', [
                    'products' => $cat1->products->where('status', 1),
                ])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn"
                        href="{{ route('front.category.slug', $cat1->slug) }}" role="button">すべて見る</a></div>
            </div>
        </section>
    @endif
    <hr>
    @if ($cat2->products->isNotEmpty())
        <div class="container">
            <div class="section-title b100">
                <h2>{{ $cat2->name }}</h2>
            </div>
            @include('front.products.product-list', ['products' => $cat2->products->where('status', 1)])
            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn"
                    href="{{ route('front.category.slug', $cat2->slug) }}" role="button">すべて見る</a></div>
        </div>
    @endif
@endsection
