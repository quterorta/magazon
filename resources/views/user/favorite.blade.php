@extends('layouts/layouts')

@section('title', 'Favorite')

@section('main-content-block')

<h1 class="shop_page__header">Favoriite</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('cabinet') }}">Zona personală</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('catalog') }}">Catalog</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Favorite</a></li>
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

@if($products->isNotEmpty())
@include('products_card.catalog_products')
<div class="shop_page__paginate">
    {{ $products->links('pagination.paginate') }}
</div>
@else
<p class="shop_page__non_shop_hint">Nu aveți încă niciun produs selectat. <a href="{{ route('catalog') }}">Adaugă-le din catalog!</a></p>
@endif

@endsection