@extends('layouts/layouts')

@section('title')
{{ $chapter->title}}
@endsection

@section('main-content-block')

<div class="catalog_page__catalog">
    <h1 class="catalog_page__catalog__header">{{ $chapter->title }}</h1>

    <div class="shop_page__breadcrumbs">
        <ul>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link active"><a>{{ $chapter->title }}</a></li>
        </ul>
    </div>

    <div class="catalog_page__catalog__chapters">
        @foreach ($chapter->categories as $category)
            <div class="catalog_page__catalog__chapters__item">
                <div><a class="catalog_page__catalog__chapters__item__parent_image_link" href="{{ route('show-category', [$chapter->alias, $category->alias]) }}"><img src="{{ Storage::url($category->image) }}" alt=""></a></div>
                <div><a class="catalog_page__catalog__chapters__item__parent_link" href="{{ route('show-category', [$chapter->alias, $category->alias]) }}">{{$category->title}}</a></div>
                <div class="catalog_page__catalog__chapters__item__child_links_block">
                @foreach ($category->sub_categories as $sub_category)
                    <a class="catalog_page__catalog__chapters__item__child_link" href="{{ route('show-sub_category', [$chapter->alias, $category->alias, $sub_category->alias]) }}">{{ $sub_category->title}}</a>
                @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Recently products -->
@if (null !== $recently_products)
@if ($recently_products->isNotEmpty())
@include('products_card.recently_products')
@endif
@endif
<!-- Recently products -->

@endsection
