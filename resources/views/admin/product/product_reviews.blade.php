@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Product reviews')

@section('main-admin-content')
    <div><h1 class="admin_main_header">Отзывы к товару "{{ $product->title }}"</h1></div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin_page__breadcrumbs">
        <ul>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('admin') }}">AdminPanel</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link"><a href="{{ route('product.index') }}">Все товары</a></li>
            <li class="admin_page__breadcrumbs__link_separator">/</li>
            <li class="admin_page__breadcrumbs__link active"><a>Отзывы к товару "{{ $product->title }}"</a></li>
        </ul>
    </div>
    
    @if ( $reviews->isNotEmpty())
    <div class="admin_review_container">
        @foreach ($reviews as $review)
        @include('admin.product.admin_reviews')
        @endforeach
    </div>

    <div class="admin_page__paginate">
        {{ $reviews->links('pagination.paginate') }}
    </div>
    @else
        <div><h2>К данному товару еще нет отзывов</h2></div>
    @endif
    

@endsection

@section('admin-side-filter')

@endsection