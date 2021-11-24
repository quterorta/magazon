<div class="products-container">

    <p class="sales-products-header container-header">Catalog cu Reduceri</p>

    <div class="sales-products-grid products-grid">
        @foreach ($sales_products as $product)
            <div class="sales-product-card product-card">
                <div class="add-to-card-container" data-product_id="{{ $product->id }}">
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
                @if ($product->product_in_sale == 1)
                <div class="sales-product-badge">
                    <span>{{ round((($product->price - $product->new_price)/$product->price)*100) }}%</span>
                </div>
                @endif
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

    <a href="{{ route('all-sales-products') }}" class="show-all-products-button show-all-sale-products-button">Toate Reducerile</a>

</div>
