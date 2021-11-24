@extends('layouts/layouts')

@section('title', 'Cart')

@section('main-content-block')

<div class="cart_page">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shop_page__alert" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h1 class="cart_page__header">Coş</h1>

    <div class="shop_page__breadcrumbs">
        <ul>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link active"><a>Coş</a></li>
        </ul>
    </div>

    @if (!\Cart::session($_COOKIE['cart_id'])->isEmpty())
        <div class="cart_page__cart_table">
            @foreach ($cart_items as $product)
                <div class="cart_page__cart_table__cart_item">

                    <div class="cart_page__cart_table__cart_item__delete">
                        <a href="{{ route('cart-remove', $product->id) }}" title="Scoateți articolul din coș"><i class="far fa-trash-alt"></i></a>
                    </div>

                    <div class="cart_page__cart_table__cart_item__image">
                        <a href="{{ route('product-detail', [$product->attributes->category->alias, $product->attributes->sub_category->alias, $product->id]) }}">
                            <img src="{{ Storage::url($product->attributes->image_cover) }}" alt="">
                        </a>
                    </div>

                    <div class="cart_page__cart_table__cart_item__title">
                        <a href="{{ route('product-detail', [$product->attributes->category->alias, $product->attributes->sub_category->alias, $product->id]) }}">
                            {{ $product->name }}
                        </a>
                    </div>

                    <div class="cart_page__cart_table__cart_item__controll">
                        <input id="cart__product_id" type="number" readonly value="{{ $product->id }}" hidden>
                        <!-- -- -->
                        <button type="button" class="plus_product_in_cart" data-product_id="{{ $product->id }}" data-product_qty="{{ $product->quantity }}">
                            <i class="fas fa-plus"></i>
                        </button>
                        <input id="cart__field_for_id_{{ $product->id}}" type="number" min="0" max="10" step="1" readonly value="{{ $product->quantity }}">
                        <button type="button" class="minus_product_in_cart" data-product_id="{{ $product->id }}" data-product_qty="{{ $product->quantity }}">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                    <div class="cart_page__cart_table__cart_item__total_price">
                        @if ( $product->quantity > 1)
                        <b>{{ \Cart::get($product->id)->getPriceSum() }} MDL</b><br>
                        {{ $product->quantity }} позиций по {{$product->price}} MDL
                        @else
                        <b>{{ $product->price }} MDL</b>
                        @endif
                    </div>

                </div>
            @endforeach
            <div class="cart_page__cart_table__total_sum_block">
                <p><b>Cost total:</b> {{ isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotal() : '0' }} MDL</p>
            </div>
            <div class="cart_page__cart_table__cart_controll">
                <a class="cart_page__cart_table__cart_controll__cart_clear" href="{{ route('cart-clear') }}">Coșul de gunoi gol</a>
                <a class="cart_page__cart_table__cart_controll__cart_order_create" href="{{ route('order.create') }}">Verifică</a>
            </div>
        </div>
    @else
        <div class="cart_page__empty_cart_block">
            <h2>Coșul dvs. este gol.</h2>
            <a href="{{ route('catalog') }}">Înapoi la cumpărături</a>
        </div>
    @endif

</div>
{{--
<div style="min-height: 77.5vh">
    <h1>Корзина</h1>
<style>
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    table th, table td{
        border: 1px solid black;
    }
</style>
@if (\Cart::session($_COOKIE['cart_id'])->isEmpty()==False )
    <table style="width: 100%; text-align:center">
        <tr>
            <th style="width: 2.5%">ID</th>
            <th style="width: 20%">Картинка</th>
            <th style="width: 20%">Название</th>
            <th style="width: 10%">Цена</th>
            <th style="width: 15%">Количество</th>
        </tr>
        @foreach ($cart_items as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ Storage::url($product->attributes->image_cover) }}" alt="" width="100px"></td>
            <td>{{ $product->name }}</td>
            <td>
                @if ( $product->quantity > 1)
                {{ \Cart::get($product->id)->getPriceSum() }} MDL<br>
                {{ $product->quantity }} позиций по {{$product->price}} MDL
                @else
                {{ $product->price }} MDL
                @endif
            </td>
            <td>
                <input id="cart__field_for_id_{{ $product->id}}" type="number" min="0" max="10" step="1" readonly value="{{ $product->quantity }}">
                <input id="cart__product_id" type="number" readonly value="{{ $product->id }}" hidden>
                <button type="button" class="plus_product_in_cart" data-product_id="{{ $product->id }}" data-product_qty="{{ $product->quantity }}">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="minus_product_in_cart" data-product_id="{{ $product->id }}" data-product_qty="{{ $product->quantity }}">
                    <i class="fas fa-minus"></i>
                </button>
                <a href="{{ route('cart-remove', $product->id) }}" title="Удалить товар из корзины"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align:right;">
                <b>Общая стоимость:</b> {{ isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotal() : '0' }} MDL
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;">
                <a href="{{ route('cart-clear') }}"><b>Очистить корзину</b></a>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;">
                <a href="{{ route('order.create') }}"><b>Оформить заказ</b></a>
            </td>
        </tr>
    </table>
@else
    <h2> Ваша корзина пуста.</h2>
    <p><a href="{{ route('home') }}">Вернуться к покупкам</a></p>
@endif
</div> --}}

@endsection
