@extends('layouts/layouts')

@section('title')
{{ $shop->title }}
@endsection

@section('additional-block')
<div class="shop_page__banner_image_block">
    <img src="{{ Storage::url($shop->banner_image) }}" alt="">
</div>
<div class="shop_page__text_block">
    <h1 class="shop_page__text_block__header">{{ $shop->title }}</h1>
    <p class="shop_page__text_block__orders_counter">{{ $products_counter }} de comenzi</p>
    <div class="shop_page__text_block__reviews_block">
        <div class="shops_page__grid_item__review_block__rating">
            <div class="rating rating_set">
                <div class="rating__body">
                    <div class="rating__active"></div>
                    <div class="rating__items">
                        <input type="radio" name="rating" class="rating__item" value=1 required>
                        <input type="radio" name="rating" class="rating__item" value=2 required>
                        <input type="radio" name="rating" class="rating__item" value=3 required>
                        <input type="radio" name="rating" class="rating__item" value=4 required>
                        <input type="radio" name="rating" class="rating__item" value=5 required>
                        <div class="rating__value">{{ round($shop->rating, 1) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shops_page__grid_item__review_block__reviews">
            <a href="#reviews">Recenzii despre magazin: <b>{{ count($shop->reviews) }}</b></a>
        </div>
    </div>
</div>
@endsection

@section('main-content-block')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show shop_page__alert" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="shop_page__products_block">

    <div class="catalog_products__buttons">

        <div class="dropdown">
            <button class="catalog_products__buttons__sort_btn" type="button" id="sortButton" data-bs-toggle="dropdown" aria-expanded="false" title="Sortarea m??rfurilor">
                <i class="fas fa-sort-amount-down"></i>
            </button>

            <div class="dropdown-menu catalog_products__buttons__sort_btn__dropdown_menu" aria-labelledby="sortButton">
                <form action="" method="GET">
                    <!-- ?????????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai ieftin') active @endif" name="sort" value="Mai ieftin">
                </form>
                <form action="" method="GET">
                    <!-- ???????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai scump') active @endif" name="sort" value="Mai scump">
                </form>
                <form action="" method="GET">
                    <!-- ???????????????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai popular mai ??nt??i') active @endif" name="sort" value="Mai popular mai ??nt??i">
                </form>
                <form action="" method="GET">
                    <!-- ???????????????????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai pu??in popular mai ??nt??i') active @endif" name="sort" value="Mai pu??in popular mai ??nt??i">
                </form>
                <form action="" method="GET">
                    <!-- ??-?? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (A-Z)') active @endif" name="sort" value="Alfabetic (A-Z)">
                </form>
                <form action="" method="GET">
                    <!-- ??-?? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (Z-A)') active @endif" name="sort" value="Alfabetic (Z-A)">
                </form>
                <form action="" method="GET">
                    <!-- ?????????????????? ???????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Produse cu reducere mai ??nt??i') active @endif" name="sort" value="Produse cu reducere mai ??nt??i">
                </form>
                <form action="" method="GET">
                    <!-- ?????????????????????????? -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Produsele recomandate mai ??nt??i') active @endif" name="sort" value="Produsele recomandate mai ??nt??i">
                </form>
            </div>
        </div>

        <button class="catalog_products__side_filter" type="button" data-bs-toggle="offcanvas" data-bs-target="#catalog_products__side_menu__filter" aria-controls="catalog_products__side_menu__filter" title="Filtru produs">
            <i class="fas fa-filter"></i>
        </button>
    </div>

    <!-- ?????????????? ???????????? ?????????????? -->
    <div class="offcanvas offcanvas-start catalog_products__side_menu__container" data-bs-scroll="true" tabindex="-1" id="catalog_products__side_menu__filter" aria-labelledby="catalog_products__side_menu__filter__label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="catalog_products__side_menu__filter__label">Filtru produs</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="??????????????"></button>
        </div>
        <div class="offcanvas-body">

            <form action="" method="GET">
            @if (null !== Request::input('sort'))
            @endif
            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_price_block" aria-expanded="false" aria-controls="spec_input_price_block">
                Pre??
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_price_block">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="spec_input_min_price">Pre?? de la</label>
                            @if ( null !== Request::input('min_price') and null !== Request::input('max_price') )
                            <input type="number" class="form-control" id="spec_input_min_price" name="min_price" required placeholder="Introduce??i pre??ul minim" value="{{ Request::input('min_price') }}" min="{{ Request::input('min_price') }}" max="{{ Request::input('max_price') }}" step="0.01">
                            @else
                            <input type="number" class="form-control" id="spec_input_min_price" name="min_price" required placeholder="Introduce??i pre??ul minim" value="{{ $products->min('price')}}" min="{{ $products->min('price') }}" max="{{ $products->max('price') }}" step="0.01">
                            @endif
                        </div>
                        <div class="col">
                            <label for="spec_input_max_price">Pre?? p??n?? la</label>
                            @if ( null !== Request::input('min_price') and null !== Request::input('max_price') )
                            <input type="number" class="form-control" id="spec_input_max_price" name="max_price" required placeholder="Introduce??i pre??ul maxim" value="{{ Request::input('max_price') }}" min="{{ Request::input('min_price') }}" max="{{ Request::input('max_price') }}" step="0.01">
                            @else
                            <input type="number" class="form-control" id="spec_input_max_price" name="max_price" required placeholder="Introduce??i pre??ul maxim" value="{{ $products->max('price')}}" min="{{ $products->min('price') }}" max="{{ $products->max('price') }}" step="0.01">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_category_block" aria-expanded="false" aria-controls="spec_input_category_block">
                Categoria de bunuri
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_category_block">
                <div class="form-group">
                    @foreach ($categories_list as $category)
                    <div class="form-check form-check-inline catalog_page__side_filter__spec_collapse_block__checkboxes">
                        <input class="form-check-input" type="checkbox" id="category_{{ $category->id }}_input" value="{{ $category->id }}" name="category[]" @if (null !== Request::input('category') and in_array($category->id, Request::input('category'))) checked @endif>
                        <label class="form-check-label" for="category_{{ $category->id }}_input">{{ $category->title}}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_sub_category_block" aria-expanded="false" aria-controls="spec_input_sub_category_block">
                Subcategoria m??rfurilor
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_sub_category_block">
                <div class="form-group">
                    @foreach ($sub_categories_list as $sub_category)
                    <div class="form-check form-check-inline catalog_page__side_filter__spec_collapse_block__checkboxes">
                        <input class="form-check-input" type="checkbox" id="sub_category_{{ $sub_category->id }}_input" value="{{ $sub_category->id }}" name="sub_category[]" @if (null !== Request::input('sub_category') and in_array($sub_category->id, Request::input('sub_category'))) checked @endif>
                        <label class="form-check-label" for="sub_category_{{ $sub_category->id }}_input">{{ $sub_category->title}}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_sort_block" aria-expanded="false" aria-controls="spec_input_sort_block">
                Sortarea m??rfurilor
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_sort_block">
                <div class="form-group">
                    <select name="sort" id="sort_by" class="form-select">
                        <option value=null disabled selected>--- Selecta??i tipul de sortare ---</option>
                        <!-- ?????????????? -->
                        <option value="Mai ieftin" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai ieftin') selected @endif>Mai ieftin</option>
                        <!-- ???????????? -->
                        <option value="Mai scump" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai scump') selected @endif>Mai scump</option>
                        <!-- ???????????????????? -->
                        <option value="Mai popular mai ??nt??i" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai popular mai ??nt??i') selected @endif>Mai popular mai ??nt??i</option>
                        <!-- ???????????????????????? -->
                        <option value="Mai pu??in popular mai ??nt??i" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai pu??in popular mai ??nt??i') selected @endif>Mai pu??in popular mai ??nt??i</option>
                        <!-- ??-?? -->
                        <option value="Alfabetic (A-Z)" @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (A-Z)') selected @endif>Alfabetic (A-Z)</option>
                        <!-- ??-?? -->
                        <option value="Alfabetic (Z-A)" @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (Z-A)') selected @endif>Alfabetic (Z-A)</option>
                        <!-- ?????????????????? ???????????? -->
                        <option value="Produse cu reducere mai ??nt??i" @if (null !== Request::input('sort') and Request::input('sort') == 'Produse cu reducere mai ??nt??i') selected @endif>Produse cu reducere mai ??nt??i</option>
                        <!-- ?????????????????????????? -->
                        <option value="Produsele recomandate mai ??nt??i" @if (null !== Request::input('sort') and Request::input('sort') == 'Produsele recomandate mai ??nt??i') selected @endif>Produsele recomandate mai ??nt??i</option>
                    </select>
                </div>
            </div>

            <button type="button" class="catalog_page__side_filter__clear_btn">??terge??i parametrii</button>
            <button type="submit" class="catalog_page__side_filter__submit_btn">Salva??i</button>
            </form>
        </div>
    </div>

    <div class="shop_page_products_block__products">

        <h2 class="shop_page__block_header">Produsele v??nz??torului</h2>

        <!-- ???????????? ?????? ???????????????? ???????????????? -->
        <div class="catalog-products-container">
            @if ($products->isEmpty() and count(Request::input()) !== 0)
            <h3 class="catalog_page__empty_products_header">
                Ne pare r??u, nu au fost g??site produse. ??ncerca??i s?? modifica??i <a type="button" data-bs-toggle="offcanvas" data-bs-target="#catalog_products__side_menu__filter" aria-controls="catalog_products__side_menu__filter" title="Filtru produs">parametrii filtrului</a>
            </h3>
            @elseif ($products->isEmpty() and count(Request::input()) == 0)
            <h3 class="catalog_page__empty_products_header">
                Ne pare r??u, ??nc?? nu exist?? produse pentru aceast?? subcategorie. Pute??i <a href="{{ route('catalog') }}" title="Accesa??i catalogul">merge la catalog</a> pentru a selecta produsul de care ave??i nevoie.
            </h3>
            @endif
            @include('products_card.catalog_products')
        </div>
        <!-- ???????????? ?????? ???????????????? ???????????????? -->

        <!-- ?????????????????? -->
        <div class="shop_page__paginate">
            {{ $products->links('pagination.paginate') }}
        </div>
        <!-- ?????????????????? -->

    </div>

</div>

<div class="shop_page__reviews_block" id="reviews">
    <h2 class="shop_page__block_header">Toate recenziile</h2>
    <div class="shop_page__reviews_block__grid">
        <div class="shop_page__reviews_block__grid_item__form" id="add-review">
            <p class="shop_page__reviews_block__grid_item__form__header">Recenzie nou??</p>
            <form action="{{ route('store-shop-review', $shop->id) }}" method="POST">
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
                    <button type="submit" class="shop_page__reviews_block__grid_item__form__button">L??sa??i feedback</button>
                    @else
                    <button type="button" class="shop_page__reviews_block__grid_item__form__button_deactivate">L??sa??i feedback</button>
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
                        <p>{{ $review->review }}</p>
                    </div>
                </div>
            @endforeach
            <!-- ?????????????????? -->
            <div class="shop_page__paginate">
                {{ $reviews->links('pagination.paginate') }}
            </div>
            <!-- ?????????????????? -->
        </div>
    </div>
</div>

<!-- Recently products -->
<div class="shop_page__recently_products_block">
    @include('products_card.recently_products')
</div>
<!-- Recently products -->

@endsection


@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function() {
            var filterBlocks = $('.catalog_page__side_filter__spec_collapse_block__checkboxes');
            filterBlocks.each(function() {

                if ($(this).children('input:checkbox').is(':checked')) {
                    $(this).parent().parent('.catalog_page__side_filter__spec_collapse_block').removeClass('collapsed');
                    $(this).parent().parent('.catalog_page__side_filter__spec_collapse_block').addClass('show');
                    $(this).parent().parent('.catalog_page__side_filter__spec_collapse_block').prev($('.catalog_page__side_filter__spec_btn')).addClass('active');
                }
            });
        });
        $(document).on('click', '.shop_page__reviews_block__grid_item__form__button_deactivate', function() {
            alert('Pentru a l??sa o recenzie, trebuie s?? v?? autentifica??i sau s?? v?? ??nregistra??i!');
        });
    </script>
@endsection
