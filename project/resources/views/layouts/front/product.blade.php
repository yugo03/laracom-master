<div class="row">
    <div class="col-md-6">
        @if (!empty($product->cover))
            <ul id="thumbnails" class="col-md-4 list-unstyled">
                <li>
                    <a href="javascript: void(0)">
                        <img class="img-responsive img-thumbnail" src="{{ $product->cover }}" alt="{{ $product->name }}" />
                    </a>
                </li>
                @if (isset($images) && !$images->isEmpty())
                    @foreach ($images as $image)
                        <li>
                            <a href="javascript: void(0)">
                                <img class="img-responsive img-thumbnail" src="{{ asset("storage/$image->src") }}"
                                    alt="{{ $product->name }}" />
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <figure class="text-center product-cover-wrap col-md-8">
                <img id="main-image" class="product-cover img-responsive" src="{{ $product->cover }}?w=400"
                    data-zoom="{{ $product->cover }}?w=1200">
            </figure>
        @else
            <figure>
                <img src="{{ asset('images/NoData.png') }}" alt="{{ $product->name }}"
                    class="img-bordered img-responsive">
            </figure>
        @endif
    </div>
    <div class="col-md-6">
        <div class="product-description">
            <h1>{{ $product->name }}
                <small>{{ config('cart.currency') }} {{ $product->price }}</small>
            </h1>
            <div class="share-product" style="margin-bottom: 10px;">
                <button type="button" class="btn btn-default btn-sm" onclick="shareProductLink(this)" data-url="{{ route('front.get.product', $product->slug) }}">
                    <i class="fa fa-share-alt"></i> <span class="share-btn-label">Share</span>
                </button>
            </div>
            <script type="text/javascript">
                function shareProductLink(btn) {
                    var url = btn.getAttribute('data-url');
                    var label = btn.querySelector('.share-btn-label');
                    var originalText = label.textContent;
                    var done = false;

                    function showCopied() {
                        if (done) {
                            return;
                        }
                        done = true;
                        label.textContent = 'Copied!';
                        setTimeout(function () {
                            label.textContent = originalText;
                        }, 2000);
                    }

                    function fallbackCopy() {
                        if (done) {
                            return;
                        }
                        var input = document.createElement('textarea');
                        input.value = url;
                        input.style.position = 'fixed';
                        input.style.opacity = '0';
                        document.body.appendChild(input);
                        input.focus();
                        input.select();
                        try {
                            document.execCommand('copy');
                            showCopied();
                        } catch (e) {}
                        document.body.removeChild(input);
                    }

                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(url).then(showCopied, fallbackCopy);
                        // Guard against the clipboard promise never settling in some browser/permission states.
                        setTimeout(fallbackCopy, 500);
                    } else {
                        fallbackCopy();
                    }
                }
            </script>
            <div class="description">{!! $product->description !!}</div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.errors-and-messages')
                    <form action="{{ route('cart.store') }}" class="form-inline" method="post">
                        {{ csrf_field() }}
                        @if (isset($productAttributes) && !$productAttributes->isEmpty())
                            <div class="form-group">
                                <label for="productAttribute">Choose Combination</label> <br />
                                <select name="productAttribute" id="productAttribute" class="form-control select2">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{ $productAttribute->id }}">
                                            @foreach ($productAttribute->attributesValues as $value)
                                                {{ $value->attribute->name }} : {{ ucwords($value->value) }}
                                            @endforeach
                                            @if (!is_null($productAttribute->sale_price))
                                                ({{ config('cart.currency_symbol') }}
                                                {{ $productAttribute->sale_price }})
                                            @elseif(!is_null($productAttribute->price))
                                                ( {{ config('cart.currency_symbol') }} {{ $productAttribute->price }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                        @endif
                        <div class="form-group">
                            <input type="text" class="form-control" name="quantity" id="quantity"
                                placeholder="Quantity" value="{{ old('quantity') }}" />
                            <input type="hidden" name="product" value="{{ $product->id }}" />
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-cart-plus"></i> Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var productPane = document.querySelector('.product-cover');
            var paneContainer = document.querySelector('.product-cover-wrap');

            new Drift(productPane, {
                paneContainer: paneContainer,
                inlinePane: false
            });
        });
    </script>
@endsection
