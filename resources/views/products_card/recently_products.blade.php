@if ( auth()->check() and auth()->user()->viewed_products->unique()->isNotEmpty())
<div class="products-container">

    <p class="recently-products-header container-header">Produse Vizualizate Recent</p>

    <div class="recently-products-grid products-grid">
        @foreach (auth()->user()->viewed_products->unique()->sortBy('created_at')->take(4) as $product)
            <div class="recently-product-card product-card">
                <div class="add-to-card-container" id="success_add_to_card_product_{{ $product->id }}">
                    <div class="add-to-card-text">
                        <p><i class="fas fa-check"></i><br>Adăugat în coș</p>
                    </div>
                </div>
                @if (Auth::user())
                    @if ($product->user_favorites()->where('users.id', Auth::user()->id)->exists())
                    <div class="favorite-product-badge">
                        <span class="favorite-product-badge-active" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="fas fa-heart"></i>
                        </span>
                        <span class="favorite-product-badge-clickable" style="display: none" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="far fa-heart"></i>
                        </span>
                    </div>
                    @else
                    <div class="favorite-product-badge">
                        <span class="favorite-product-badge-clickable" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="far fa-heart"></i>
                        </span>
                        <span class="favorite-product-badge-active" style="display: none" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="fas fa-heart"></i>
                        </span>
                    </div>
                    @endif
                @else
                <div class="favorite-product-badge">
                    <span class="favorite-product-badge-inactive"><i class="fas fa-heart"></i></span>
                </div>
                @endif
                <div class="recently-product-badge">
                    <span><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 226 226" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,226v-226h226v226z" fill="none"></path><g fill="#1d257a"><path d="M35.73625,4.37875c-0.19422,0.03531 -0.38844,0.08828 -0.565,0.14125c-2.10109,0.47672 -3.58422,2.36594 -3.53125,4.52v45.2h45.2c1.62438,0.01766 3.14281,-0.82984 3.97266,-2.24234c0.81219,-1.4125 0.81219,-3.14281 0,-4.55531c-0.82984,-1.4125 -2.34828,-2.26 -3.97266,-2.24234h-30.08625c17.00297,-16.70281 40.34453,-27.12 66.24625,-27.12c52.72156,0 94.92,42.19844 94.92,94.92c0,52.72156 -42.19844,94.92 -94.92,94.92c-52.72156,0 -94.92,-42.19844 -94.92,-94.92c0,-15.51984 3.83141,-30.70422 10.31125,-43.64625l-8.05125,-4.09625c-7.08016,14.17797 -11.3,30.72187 -11.3,47.7425c0,57.55938 46.40063,103.96 103.96,103.96c57.55938,0 103.96,-46.40062 103.96,-103.96c0,-57.55937 -46.40062,-103.96 -103.96,-103.96c-28.12641,0 -53.71031,11.28234 -72.32,29.38v-29.38c0.05297,-1.30656 -0.47672,-2.56016 -1.4125,-3.44297c-0.95344,-0.90047 -2.24234,-1.34187 -3.53125,-1.21828zM108.48,40.68v64.55125c-2.70141,1.57141 -4.52,4.43172 -4.52,7.76875c0,0.77688 0.08828,1.53609 0.2825,2.26l-30.65125,30.65125l6.4975,6.4975l30.65125,-30.65125c0.72391,0.19422 1.48313,0.2825 2.26,0.2825c4.99672,0 9.04,-4.04328 9.04,-9.04c0,-3.33703 -1.81859,-6.19734 -4.52,-7.76875v-64.55125z"></path></g></g></svg></span>
                </div>
                <div class="product-card-image-container">
                    <a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}" class="product-card-link">
                        <img class="product-card-image" src="{{ Storage::url($product->image_cover) }}" alt="">
                    </a>
                </div>
                <a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}" class="product-card-title">
                    {{ Str::limit($product->title, 22, '...') }}
                </a>
                <p class="product-card-price">
                    @if ( $product->new_price !== null and $product->product_in_sale == 1)
                    {{ $product->new_price }} mdl
                    <sup>{{ $product->price }}</sup>
                    @else
                    {{ $product->price }} mdl @endif
                </p>
                <p class="product-card-loan">@if ($product->loan_terms !== null){{ $product->loan_terms }}@else Стандартные условия кредита @endif</p>
                <button type="button" class="product_card__add_to_cart_btn" data-product_id="{{ $product->id }}">Adauga in cos</button>
            </div>
        @endforeach
    </div>

    <a href="{{ route('view-history') }}" class="show-all-products-button show-all-recently-products-button">Tot istoricul navigării</a>

</div>

@endif
