@extends('layouts/layouts')

@section('title')
{{ $category->title}}
@endsection

@section('main-content-block')

<div class="catalog_page__catalog">
    <h1 class="catalog_page__catalog__header">{{ $category->title }}</h1>

    <div class="shop_page__breadcrumbs">
        <ul>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('show-chapter', $category->chapter->alias) }}">{{ $category->chapter->title }}</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link active"><a>{{ $category->title }}</a></li>
        </ul>
    </div>

    <div class="catalog_page__categories_grid_links">
        @foreach ($category->sub_categories as $sub_category)
            <a class="catalog_page__categories_grid_item" href="{{ route('show-sub_category', [$category->chapter->alias, $category->alias, $sub_category->alias]) }}">
                {{ $sub_category->title }}
            </a>
        @endforeach
    </div>

    <!-- Товары для текущей категории -->
    <div class="catalog-products-container">
        <p class="sales-products-header container-header">Produse din categorie</p>


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

        </div>

        @include('products_card.catalog_products')
    </div>
    <!-- Товары для текущей категории -->

    <!-- Пагинация -->
    <div class="shop_page__paginate">
        {{ $products->links('pagination.paginate') }}
    </div>
    <!-- Пагинация -->
</div>

<!-- Recently products -->
@if (null !== $recently_products)
@include('products_card.recently_products')
@endif
<!-- Recently products -->

@endsection
