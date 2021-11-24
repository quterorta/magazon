@extends('layouts/layouts')

@section('title')
Catalog
@endsection

@section('main-content-block')

<div class="catalog_page__catalog">
    <h1 class="catalog_page__catalog__header">Catalog</h1>

    <div class="shop_page__breadcrumbs">
        <ul>
            <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
            <li class="shop_page__breadcrumbs__link_separator">/</li>
            <li class="shop_page__breadcrumbs__link active"><a>Catalog</a></li>
        </ul>
    </div>

    <div class="catalog_page__catalog__chapters">
        @foreach ($chapters as $chapter)
            <div class="catalog_page__catalog__chapters__item">
                <div><a class="catalog_page__catalog__chapters__item__parent_image_link" href="{{ route('show-chapter', $chapter->alias) }}"><img src="{{ Storage::url($chapter->image) }}" alt=""></a></div>
                <div><a class="catalog_page__catalog__chapters__item__parent_link" href="{{ route('show-chapter', $chapter->alias) }}">{{$chapter->title}}</a></div>
                <div class="catalog_page__catalog__chapters__item__child_links_block">
                @foreach ($chapter->categories as $category)
                    <a class="catalog_page__catalog__chapters__item__child_link" href="{{ route('show-category', [$chapter->alias, $category->alias]) }}">{{ $category->title}}</a>
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
