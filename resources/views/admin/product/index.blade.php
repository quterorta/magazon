@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All products')

@section('main-admin-content')
    <div><h1 class="admin_main_header">Все товары</h1></div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    
    @if ( $pre_moderated_products->isNotEmpty())
    <div><h2 class="admin_main_subheader">Ожидающие модерации</h2></div>
    <div class="admin_products_container">
        @foreach ($pre_moderated_products as $product)
        @include('admin.product.admin_product_card')
        @endforeach
    </div>
    <div class="admin_page__paginate">
        {{ $pre_moderated_products->links('pagination.paginate') }}
    </div>
    @endif
    
    <div><h2 class="admin_main_subheader">Прошли модерацию</h2></div>
    <div class="admin_products_container">
        @foreach ($products as $product)
        @include('admin.product.admin_product_card')
        @endforeach
    </div>

    @if ( $pre_moderated_products->isNotEmpty())
    <div class="admin_page__paginate">
        {{ $products->links('pagination.paginate') }}
    </div>
    @endif

@endsection

@section('admin-side-filter')
@include('admin.product.admin_product_filter')
@endsection













