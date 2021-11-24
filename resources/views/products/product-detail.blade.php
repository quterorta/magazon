@extends('layouts/layouts')

@section('title', $product->title)

@section('main-content-block')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show shop_page__alert" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-chapter', $product->category->chapter->alias) }}">{{ $product->category->chapter->title }}</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-category', [$product->category->chapter->alias, $product->category->alias]) }}">{{ $product->category->title }}</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-sub_category', [$product->category->chapter->alias, $product->category->alias, $product->sub_category->alias]) }}">{{ $product->sub_category->title }}</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>{{ $product->title }}</a></li>
    </ul>
</div>

<div class="product_page__first_section_grid">

    <div class="product_page__first_section_grid__image_galery_block">
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
        <div class="fotorama"
            data-allowfullscreen="false" 
            data-arrows="false"
            data-click="true"
            data-swipe="true" 
            data-nav="thumbs" 
            data-fit="contain"
            data-thumbfit="contain"
            data-height="300" data-width="100%">
                <div data-thumb="{{ Storage::url($product->image_cover) }}">
                    <a data-src="{{ Storage::url($product->image_cover) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_cover) }}" alt="">
                    </a>
                </div>
                @if($product->image_1 !== null)
                <div data-thumb="{{ Storage::url($product->image_1) }}">
                    <a data-src="{{ Storage::url($product->image_1) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_1) }}" alt="">
                    </a>
                </div>
                @endif
                @if($product->image_2 !== null)
                <div data-thumb="{{ Storage::url($product->image_2) }}">
                    <a data-src="{{ Storage::url($product->image_2) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_2) }}" alt="">
                    </a>
                </div>
                @endif
                @if($product->image_3 !== null)
                <div data-thumb="{{ Storage::url($product->image_3) }}">
                    <a data-src="{{ Storage::url($product->image_3) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_3) }}" alt="">
                    </a>
                </div>
                @endif
                @if($product->image_4 !== null)
                <div data-thumb="{{ Storage::url($product->image_4) }}">
                    <a data-src="{{ Storage::url($product->image_4) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_4) }}" alt="">
                    </a>
                </div>
                @endif
                @if($product->image_5!==null)
                <div data-thumb="{{ Storage::url($product->image_5) }}">
                    <a data-src="{{ Storage::url($product->image_5) }}" data-fancybox="product_gallery">
                        <img src="{{ Storage::url($product->image_5) }}" alt="">
                    </a>
                </div>
                @endif
        </div>
        <div class="grid-2">
            <p class="shop_page__text_block__orders_counter">{{ count($product->rewiews) }} de comenzi</p>
            <div class="rating rating_set">
                <div class="rating__body">
                    <div class="rating__active"></div>
                    <div class="rating__items">
                        <input type="radio" name="rating" class="rating__item" value=1 required>
                        <input type="radio" name="rating" class="rating__item" value=2 required>
                        <input type="radio" name="rating" class="rating__item" value=3 required>
                        <input type="radio" name="rating" class="rating__item" value=4 required>
                        <input type="radio" name="rating" class="rating__item" value=5 required>
                        <div class="rating__value">{{ round($product->rewiews->avg('rating'), 1) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product_page__first_section_grid__text_block">
        <p class="product_page__first_section__seller"><a href="{{ route('detail-shop', $product->shop->slug) }}">{{ $product->shop->title }}</a></p>
        <div class="grid-2">
            <p class="shop_page__text_block__orders_counter">{{ $products_counter }} de comenzi</p>
            <div class="rating rating_set">
                <div class="rating__body">
                    <div class="rating__active"></div>
                    <div class="rating__items">
                        <input type="radio" name="rating" class="rating__item" value=1 required>
                        <input type="radio" name="rating" class="rating__item" value=2 required>
                        <input type="radio" name="rating" class="rating__item" value=3 required>
                        <input type="radio" name="rating" class="rating__item" value=4 required>
                        <input type="radio" name="rating" class="rating__item" value=5 required>
                        <div class="rating__value">{{ round($product->shop->reviews->avg('rating'), 1) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="shop_page__product_title">{{ Str::limit($product->title, 140, '...') }}</h1>
        <p class="shop_page__price">
            @if ( $product->new_price !== null and $product->product_in_sale == 1)
            {{ $product->new_price }} mdl
            <sup>{{ $product->price }}</sup>
            @else
            {{ $product->price }} mdl @endif
        </p>
        <p class="shop_page__article">Codul produsului: {{ $product->article }}</p>
        <p class="shop_page__favorite_count">Adăugat la favorite de {{ $product->user_favorites()->count() }} de ori</p>
        <p class="shop_page__short_description">{{ $product->short_description }}</p>
        <div class="shop_page__buy_block">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <input type="number" min="1" max="10" step="1" id="product_qty" value="1" class="product_qty_input" required>
                    <input type="number" id="product_id" value="{{ $product->id }}" hidden readonly>
                </div>
                <div class="col-lg-6">
                    <button type="button" class="product__add_to_cart_btn cart-button">
                        <span class="add-to-cart">Adauga in cos</span>
                        <span class="added">Adăugat!</span>
                        <i class="fas fa-shopping-cart"></i>
                        <i class="fas fa-box"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="product_page__second_section">
    <p class="product_page__description__header">Descriere produs</p>
    <p class="product_page__description">{{ $product->description }}</p>
    <p class="product_page__specifications__header">Caracteristicile produsului</p>
    <ul class="product_page__specifications">
        @foreach ($product->specifications as $spec)
        <li><b>{{ $spec->name }}:</b> {{ $spec->value }} {{ $spec->dimension }}</li>
        @endforeach
    </ul>
</div>

<div class="shop_page__reviews_block" id="reviews">
    <h2 class="shop_page__block_header">Toate recenziile</h2>
    <div class="shop_page__reviews_block__grid">
        <div class="shop_page__reviews_block__grid_item__form" id="add-review">
            <p class="shop_page__reviews_block__grid_item__form__header">Recenzie nouă</p>
            <form action="{{ route('store-product-review', $product->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="rating rating_set">
                        <div class="rating__body">
                            <div class="rating__active"></div>
                            <div class="rating__items">
                                <input type="radio" name="rating" class="rating__item" value=1 required>
                                <input type="radio" name="rating" class="rating__item" value=2 required>
                                <input type="radio" name="rating" class="rating__item" value=3 required>
                                <input type="radio" name="rating" class="rating__item" value=4 required>
                                <input type="radio" name="rating" class="rating__item" value=5 required>
                                <div class="rating__value">0.0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shop_review_text">Revizuire</label>
                    <textarea class="form-control" rows="5" name="review" id="shop_review_text" placeholder="Scrie o recenzie" required></textarea>
                </div>
                <div class="form-group d-grid">
                    @if (auth()->check())
                    <button type="submit" class="shop_page__reviews_block__grid_item__form__button">Lăsați feedback</button>
                    @else
                    <button type="button" class="shop_page__reviews_block__grid_item__form__button_deactivate">Lăsați feedback</button>
                    @endif
                </div>
            </form>
        </div>
        <div class="shop_page__reviews_block__grid_item__reviews">
            @foreach ($reviews as $review)
                <div class="shop_page__reviews_block__grid_item__reviews__review_card">
                    <div class="shop_page__reviews_block__grid_item__reviews__review_card__top_section">
                        <p class="shop_page__reviews_block__grid_item__reviews__review_card__top_section__name">{{ $review->user->name }}</p>
                        <div class="shop_page__reviews_block__grid_item__reviews__review_card__top_section__rating">
                            <div class="rating rating_set">
                                <div class="rating__body">
                                    <div class="rating__active"></div>
                                    <div class="rating__items">
                                        <input type="radio" name="rating" class="rating__item" value=1 required>
                                        <input type="radio" name="rating" class="rating__item" value=2 required>
                                        <input type="radio" name="rating" class="rating__item" value=3 required>
                                        <input type="radio" name="rating" class="rating__item" value=4 required>
                                        <input type="radio" name="rating" class="rating__item" value=5 required>
                                        <div class="rating__value">{{ round($review->rating, 1) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shop_page__reviews_block__grid_item__reviews__review_card__bottom_section">
                        <p>{{ $review->rewiew }}</p>
                    </div>
                </div>
            @endforeach
            <!-- Пагинация -->
            <div class="shop_page__paginate">
                {{ $reviews->links('pagination.paginate') }}
            </div>
            <!-- Пагинация -->
        </div>
    </div>
</div>

<div>
    @include('products_card.similar_products')
</div>

<div>@include('products_card.recently_products')</div>

@endsection
