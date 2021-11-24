@extends('layouts/layouts')

@section('title')
Запрос на подтверждение магазина
@endsection

@section('main-content-block')

<h1 class="shop__header">Запрос на подтверждение магазина "{{ $shop->title }}"</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Запрос на подтверждение</a></li>
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

<div class="shop-confirm-block">
    <form action="{{ route('create-shop-confirm-application', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="text_1">Текст 1</label>
            <input type="text" name="text_1" id="text_1" class="form-control" required placeholder="Введите текст1">
        </div>
        <div class="form-group">
            <label for="text_2">Текст 2</label>
            <input type="text" name="text_2" id="text_2" class="form-control" required placeholder="Введите text_2">
        </div>
        <div class="form-group">
            <label for="text_3">Текст 3</label>
            <input type="text" name="text_3" id="text_3" class="form-control" required placeholder="Введите text_3">
        </div>
        <div class="form-group d-grid mb-3">
            <button type="submit" class="btn btn-success">Подать запрос</button>
        </div>
    </form>
</div>

@endsection
