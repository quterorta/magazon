@extends('layouts/layouts')

@section('title')
MagazON | "{{ $shop->title }}" | Все заказы
@endsection

@section('main-content-block')

<h1 class="shop_page__header">Заказы с Вашими товарами</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('statistic-shop', $shop->id) }}">Статистика</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Все заказы</a></li>
    </ul>
</div>

<div class="shop_page__control_btns">
    <div class="dropdown">
        <a href="#" role="button" id="sortMenuLinks" data-bs-toggle="dropdown" aria-expanded="false" class="shop_page__all_products__control_links">@if (isset($sort_type)) Сортировка: {{ $sort_type }} @else Сортировка @endif</a>
        <ul class="dropdown-menu shop_page__dropdown_menu" aria-labelledby="sortMenuLinks">
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-status-0") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-orders', [$shop->id, "by-status-0"]) }}">Оформленные</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-status-1") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-orders', [$shop->id, "by-status-1"]) }}">Подтвержденные</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-status-2") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-orders', [$shop->id, "by-status-2"]) }}">Выполненные</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-status-3") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-orders', [$shop->id, "by-status-3"]) }}">Отмененные</a></li>
        </ul>
    </div>
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

@if (count($shop_orders) !== 0)
<div class="shop_page__all_orders_block">

    <table class="shop_page__all_orders">
        <tr class="shop_page__all_orders__table_header">
            <th class="shop_page__all_orders__table__id_th">ID</th>
            <th class="shop_page__all_orders__table__status_th">Статус</th>
            <th class="shop_page__all_orders__table__products_th">Товары</th>
            <th class="shop_page__all_orders__table__info_th">Информация</th>
            <th class="shop_page__all_orders__table__date_th">Дата</th>
        </tr>
        @foreach ($shop_orders as $order)
        <tr class="shop_page__all_orders__table_item">
            <td class="shop_page__all_orders__table__id_td">{{ $order->id }}</td>
            <td class="shop_page__all_orders__table__status_td">@if ($order->status == 0) Оформлен @elseif($order->status == 1) Подтвержден @elseif($order->status == 2) Выполнен @elseif($order->status == 3) Отменен @endif</td>
            <td class="shop_page__all_orders__table__products_td">
                @foreach ($order->products->unique() as $product)
                <a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}">{{ $product->title }}</a> x {{ $order->products->countBy('id')[$product->id] }}<br>
                @endforeach
            </td>
            <td class="shop_page__all_orders__table__info_td">
                <b>Адрес:</b> {{ $order->country->title }}, {{ $order->region->title }}, {{ $order->city->title }}, {{ $order->adress_shipment }}<br>
                <b>ФИО:</b> {{ $order->last_name }}, {{ $order->name }}<br>
                <b>Контакты:</b> <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a>, <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
            </td>
            <td class="shop_page__all_orders__table__date_td">{{ $order->created_at }}</td>
        </tr>
        @endforeach
    </table>

</div>
@else
<h2 class="shop_page__empty_header">Пока нет заказов с <a href="{{ route('all-shop-products', $shop->id) }}">Вашими товарами</a>.</h2>
@endif

@endsection
