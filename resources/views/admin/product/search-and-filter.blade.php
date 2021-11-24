@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Search products')

@section('main-admin-content')
    <div><h1 class="admin_main_header">Поиск товаров</h1></div>
    
    <div class="admin_page__breadcrumbs">
        <ul>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('admin') }}">AdminPanel</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('product.index') }}">Все товары</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link active"><a>Поиск товаров</a></li>
        </ul>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if ( $search_products->isNotEmpty())
    <div><h2 class="admin_main_subheader">Товары по запросу: "{{ $request->q }}"</h2></div>
    <div class="admin_products_container">
        @foreach ($search_products as $product)
        @include('admin.product.admin_product_card')
        @endforeach
    </div>
    <div class="admin_page__paginate">
        {{ $search_products->links('pagination.paginate') }}
    </div>
    @else
    <div><h2>Товаров по запросу "{{ $request->q }}" не найдено, попробуйте изменить настройки поиска</h2></div>
    @endif

@endsection

@section('admin-side-filter')
@include('admin.product.admin_product_filter')
@endsection