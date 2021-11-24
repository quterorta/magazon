@extends('layouts/layouts')

@section('title', 'Category')

@section('main-content-block')

<h1>{{ $category->title }}</h1>
<div class="row">
    <div class="col-lg-9">
        <p>Показано <b>{{ $products_for_category->count() }}</b> товаров</p>
    </div>
    <div class=col-lg-3>
        <span class="product_sorting_btn" data-order="default">Default</span><br>
        <span class="product_sorting_btn" data-order="price-l-h">Price: Low-Hight</span><br>
        <span class="product_sorting_btn" data-order="price-h-l">Price: Hight-Low</span><br>
        <span class="product_sorting_btn" data-order="name-a-z">Name: A-Z</span><br>
        <span class="product_sorting_btn" data-order="name-z-a">Name: Z-A</span><br>
    </div>
</div>

<ul>
    @foreach ($products_for_category as $product)
    <li style="border: 1px solid grey; margin: 5px 0; width: 20%; padding: 5px 10px;">
        <a href="{{ route('showProduct', [$category->alias, $product->alias]) }}">
            {{ $product->title }}<br><b>{{ $product->price }} MDL</b>
        </a>
    </li>
    @endforeach
</ul>

@endsection
