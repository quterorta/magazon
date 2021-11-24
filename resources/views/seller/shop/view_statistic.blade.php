@extends('layouts/layouts')

@section('title')
MagazON | "{{ $shop->title }}" | Статистика просмотров
@endsection

@section('main-content-block')

<h1 class="shop_page__header">Статистика просмотров</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('statistic-shop', $shop->id) }}">Статистика</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Статистика просмотров</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (isset($errors))
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $error }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach
@endif

<div class="shop_page__view_statistic_block">
    <div class="shop_page__shop_view_statistic">
        <p class="shop_page__shop_view_statistic__text">Всего просмотров страницы магазина "{{ $shop->title }}": <b class="@if ($shop->view_count > 40) top_view_product @elseif($shop->view_count < 40 and $shop->view_count> 20) middle_view_product @elseif($shop->view_count < 20) low_view_product @endif">{{ $shop->view_count }}</b></p>
    </div>
    <div class="shop_page__products_view_statistic">
        <h2 class="shop_page__products_view_statistic__header">Статистика просмотров товаров:</h2>
        <table class="shop_page__products_view_statistic__table">
            <tr class="shop_page__products_view_statistic__table__header">
                <th class="shop_page__products_view_statistic__table__id__th">ID товара</th>
                <th class="shop_page__products_view_statistic__table__title__th">Товар</th>
                <th class="shop_page__products_view_statistic__table__all_views__th">Всего просмотров</th>
                <th class="shop_page__products_view_statistic__table__register_views__th">Просмотров зарегистрированными пользователями</th>
            </tr>
            @foreach ($products as $product)
            <tr class="shop_page__products_view_statistic__table__item">
                <td class="shop_page__products_view_statistic__table__id__td">{{ $product->id}}</td>
                <td class="shop_page__products_view_statistic__table__title__td">
                    <a href="{{ route('edit-shop-product', [$shop->id, $product->id]) }}">{{ $product->title }}</a>
                </td>
                <td class="shop_page__products_view_statistic__table__all_views__td @if ($product->view_count > 40) top_view_product @elseif($product->view_count < 40 and $product->view_count> 20) middle_view_product @elseif($product->view_count < 20) low_view_product @endif">
                    @if ( $product->view_count == null ) 0 @else {{ $product->view_count}} @endif
                </td>
                <td class="shop_page__products_view_statistic__table__register_views__td @if ($product->user_views->count() > 40) top_view_product @elseif($product->user_views->count() < 40 and $product->user_views->count() > 20) middle_view_product @elseif($product->user_views->count() < 20) low_view_product @endif">
                    {{ $product->user_views->count() }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="shop_page__paginate">
    {{ $products->links('pagination.paginate') }}
</div>

@endsection
