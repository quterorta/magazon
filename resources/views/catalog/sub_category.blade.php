@extends('layouts/layouts')

@section('title')
{{ $sub_category->title}}
@endsection

@section('main-content-block')

<div class="catalog_page__catalog">
    <h1 class="catalog_page__catalog__header">{{ $sub_category->title }}</h1>

    <div class="shop_page__breadcrumbs">
        <ul>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-chapter', $sub_category->category->chapter->alias) }}">{{ $sub_category->category->chapter->title }}</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-category', [$sub_category->category->chapter->alias, $sub_category->category->alias]) }}">{{ $sub_category->category->title }}</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link active"><a>{{ $sub_category->title }}</a></li>
        </ul>
    </div>

    <div class="catalog_products__buttons">

        <div class="dropdown">
            <button class="catalog_products__buttons__sort_btn" type="button" id="sortButton" data-bs-toggle="dropdown" aria-expanded="false" title="Sortarea mărfurilor">
                <i class="fas fa-sort-amount-down"></i>
            </button>

            <div class="dropdown-menu catalog_products__buttons__sort_btn__dropdown_menu" aria-labelledby="sortButton">
                <form action="" method="GET">
                    <!-- Дешевле -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai ieftin') active @endif" name="sort" value="Mai ieftin">
                </form>
                <form action="" method="GET">
                    <!-- Дороже -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai scump') active @endif" name="sort" value="Mai scump">
                </form>
                <form action="" method="GET">
                    <!-- Популярные -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai popular mai întâi') active @endif" name="sort" value="Mai popular mai întâi">
                </form>
                <form action="" method="GET">
                    <!-- Непопулярные -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Mai puțin popular mai întâi') active @endif" name="sort" value="Mai puțin popular mai întâi">
                </form>
                <form action="" method="GET">
                    <!-- А-Я -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (A-Z)') active @endif" name="sort" value="Alfabetic (A-Z)">
                </form>
                <form action="" method="GET">
                    <!-- Я-А -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (Z-A)') active @endif" name="sort" value="Alfabetic (Z-A)">
                </form>
                <form action="" method="GET">
                    <!-- Скидочные товары -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Produse cu reducere mai întâi') active @endif" name="sort" value="Produse cu reducere mai întâi">
                </form>
                <form action="" method="GET">
                    <!-- Рекомендуемые -->
                    <input type="submit" class="catalog_products__dropdown_menu__sort_button @if (null !== Request::input('sort') and Request::input('sort') == 'Produsele recomandate mai întâi') active @endif" name="sort" value="Produsele recomandate mai întâi">
                </form>
            </div>
        </div>

        <button class="catalog_products__side_filter" type="button" data-bs-toggle="offcanvas" data-bs-target="#catalog_products__side_menu__filter" aria-controls="catalog_products__side_menu__filter" title="Filtru produs">
            <i class="fas fa-filter"></i>
        </button>
    </div>

    <!-- Боковой фильтр товаров -->
    <div class="offcanvas offcanvas-start catalog_products__side_menu__container" data-bs-scroll="true" tabindex="-1" id="catalog_products__side_menu__filter" aria-labelledby="catalog_products__side_menu__filter__label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="catalog_products__side_menu__filter__label">Filtru produs</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body">

            <form action="" method="GET">
            @if (null !== Request::input('sort'))
            @endif
            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_price_block" aria-expanded="false" aria-controls="spec_input_price_block">
                Preț
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_price_block">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="spec_input_min_price">Preț de la</label>
                            @if ( null !== Request::input('min_price') and null !== Request::input('max_price') )
                            <input type="number" class="form-control" id="spec_input_min_price" name="min_price" required placeholder="Introduceți prețul minim" value="{{ Request::input('min_price') }}" min="{{ Request::input('min_price') }}" max="{{ Request::input('max_price') }}" step="0.01">
                            @else
                            <input type="number" class="form-control" id="spec_input_min_price" name="min_price" required placeholder="Introduceți prețul minim" value="{{ $products->min('price')}}" min="{{ $products->min('price') }}" max="{{ $products->max('price') }}" step="0.01">
                            @endif
                        </div>
                        <div class="col">
                            <label for="spec_input_max_price">Preț până la</label>
                            @if ( null !== Request::input('min_price') and null !== Request::input('max_price') )
                            <input type="number" class="form-control" id="spec_input_max_price" name="max_price" required placeholder="Introduceți prețul maxim" value="{{ Request::input('max_price') }}" min="{{ Request::input('min_price') }}" max="{{ Request::input('max_price') }}" step="0.01">
                            @else
                            <input type="number" class="form-control" id="spec_input_max_price" name="max_price" required placeholder="Introduceți prețul maxim" value="{{ $products->max('price')}}" min="{{ $products->min('price') }}" max="{{ $products->max('price') }}" step="0.01">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($specifications->unique('name') as $specification)
            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_{{ $specification->id }}_block" aria-expanded="false" aria-controls="spec_input_{{ $specification->id }}_block">
                {{ $specification->name }}
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_{{ $specification->id }}_block">
                @foreach ($specifications as $spec)
                    @if ($spec->name == $specification->name)
                    <div class="form-check form-check-inline catalog_page__side_filter__spec_collapse_block__checkboxes">
                        <input class="form-check-input" type="checkbox" id="specification_input_{{ $spec->id }}" value="{{ $spec->id }}" name="{{ $spec->name }}[]" @if (null !== Request::input(str_replace(' ', '_', $spec->name)) and in_array($spec->id, Request::input(str_replace(' ', '_', $spec->name)))) checked @endif>
                        <label class="form-check-label" for="specification_input_{{ $spec->id }}">{{ $spec->value}} @if ( null !== $spec->dimension ){{ $spec->dimension }}@endif</label>
                    </div>
                    @endif
                @endforeach
            </div>
            @endforeach

            <button class="catalog_page__side_filter__spec_btn" type="button" data-bs-toggle="collapse" data-bs-target="#spec_input_sort_block" aria-expanded="false" aria-controls="spec_input_sort_block">
                Sortarea mărfurilor
            </button>
            <div class="collapse catalog_page__side_filter__spec_collapse_block" id="spec_input_sort_block">
                <div class="form-group">
                    <select name="sort" id="sort_by" class="form-select">
                        <option value=null disabled selected>--- Selectați tipul de sortare ---</option>
                        <!-- Дешевле -->
                        <option value="Mai ieftin" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai ieftin') selected @endif>Mai ieftin</option>
                        <!-- Дороже -->
                        <option value="Mai scump" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai scump') selected @endif>Mai scump</option>
                        <!-- Популярные -->
                        <option value="Mai popular mai întâi" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai popular mai întâi') selected @endif>Mai popular mai întâi</option>
                        <!-- Непопулярные -->
                        <option value="Mai puțin popular mai întâi" @if (null !== Request::input('sort') and Request::input('sort') == 'Mai puțin popular mai întâi') selected @endif>Mai puțin popular mai întâi</option>
                        <!-- А-Я -->
                        <option value="Alfabetic (A-Z)" @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (A-Z)') selected @endif>Alfabetic (A-Z)</option>
                        <!-- Я-А -->
                        <option value="Alfabetic (Z-A)" @if (null !== Request::input('sort') and Request::input('sort') == 'Alfabetic (Z-A)') selected @endif>Alfabetic (Z-A)</option>
                        <!-- Скидочные товары -->
                        <option value="Produse cu reducere mai întâi" @if (null !== Request::input('sort') and Request::input('sort') == 'Produse cu reducere mai întâi') selected @endif>Produse cu reducere mai întâi</option>
                        <!-- Рекомендуемые -->
                        <option value="Produsele recomandate mai întâi" @if (null !== Request::input('sort') and Request::input('sort') == 'Produsele recomandate mai întâi') selected @endif>Produsele recomandate mai întâi</option>
                    </select>
                </div>
            </div>

            <button type="button" class="catalog_page__side_filter__clear_btn">Ștergeți parametrii</button>
            <button type="submit" class="catalog_page__side_filter__submit_btn">Salvați</button>
            </form>
        </div>
    </div>
    <!-- Боковой фильтр товаров -->

    <!-- Товары для текущей подкатегории -->
    <div class="catalog-products-container">
        @if ($products->isEmpty() and count(Request::input()) !== 0)
        <h3 class="catalog_page__empty_products_header">
            Ne pare rău, nu au fost găsite produse. Încercați să modificați <a type="button" data-bs-toggle="offcanvas" data-bs-target="#catalog_products__side_menu__filter" aria-controls="catalog_products__side_menu__filter" title="Filtru produs">parametrii filtrului</a>
        </h3>
        @elseif ($products->isEmpty() and count(Request::input()) == 0)
        <h3 class="catalog_page__empty_products_header">
            Ne pare rău, încă nu există produse pentru această subcategorie. Puteți <a href="{{ route('catalog') }}" title="Accesați catalogul">merge la catalog</a> pentru a selecta produsul de care aveți nevoie.
        </h3>
        @endif
        @include('products_card.catalog_products')
    </div>
    <!-- Товары для текущей подкатегории -->

    <!-- Пагинация -->
    @if ( $products->isNotEmpty())
    <div class="shop_page__paginate">
        {{ $products->links('pagination.paginate') }}
    </div>
    @endif
    <!-- Пагинация -->
</div>

<!-- Recently products -->
@if (null !== $recently_products)
@if ( $recently_products->isNotEmpty() )
@include('products_card.recently_products')
@endif
@endif
<!-- Recently products -->

@endsection

@section('custom_js')
    <script type="text/javascript">
        filterCheck();
    </script>
@endsection
