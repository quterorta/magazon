@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Pre moderated products')

@section('main-admin-content')
    <div><h1 class="admin_main_header">Ожидают модерацию</h1></div>
    
    <div class="admin_page__breadcrumbs">
        <ul>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('admin') }}">AdminPanel</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('product.index') }}">Все товары</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link active"><a>Ожидающие модерацию</a></li>
        </ul>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    
    @if ( $pre_moderated_products->isNotEmpty())
    <div class="admin_products_container">
        @foreach ($pre_moderated_products as $product)
            @include('admin.product.admin_product_card')
        @endforeach
    </div>
    <div class="admin_page__paginate">
        {{ $pre_moderated_products->links('pagination.paginate') }}
    </div>
    @endif

@endsection