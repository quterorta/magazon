@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | All products in shop "{{ $shop->title }}"
@endsection

@section('main-admin-content')
    <h1>Все товары магазина "{{ $shop->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-subcategory-list">
        <table style="width: 100%">
            <tr>
                <th style="width: 10%">ID</th>
                <th style="width: 20%">Название</th>
                <th style="width: 20%">Обложка</th>
                <th style="width: 20%">Прошел модерацию</th>
                <th style="width: 30%">Controls</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td style="width: 10%">{{ $product->id }}</td>
                <td style="width: 20%">{{ $product->title }}</td>
                <td style="width: 20%"><img src="{{ Storage::url($product->image_cover) }}" alt="" width="100%"></td>
                <td style="width: 20%">@if ($product->moderate === 1) Да @else Нет @endif</td>
                <td style="width: 30%">
                    <a href="{{ route('product.edit', $product->id) }}">Редактировать</a>
                    <form action="{{ route('product.destroy', $prodcut->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $product->title }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $products->links('pagination.paginate') }}

@endsection
