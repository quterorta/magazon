@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All review')

@section('main-admin-content')
    <h1>Все отзывы</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-subcategory-list">
        <table style="width: 100%">
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 20%">Товар</th>
                <th style="width: 20%">Оценка</th>
                <th style="width: 20%">Отзыв</th>
                <th style="width: 20%">Пользователь</th>
                <th style="width: 15%">Controls</th>
            </tr>
            @foreach ($rewiews as $rewiew)
            <tr>
                <td style="width: 5%">{{ $rewiew->id }}</td>
                <td style="width: 20%">
                    <i>{{ $rewiew->product->sub_category->category->chapter->title }}, {{ $rewiew->product->sub_category->category->title }}, {{ $rewiew->product->sub_category->title }}</i><br>
                    <a href="{{ route('product.edit', $rewiew->product->id) }}">{{ $rewiew->product->title }}</a>
                </td>
                <td style="width: 20%">{{ $rewiew->rating }}</td>
                <td style="width: 20%">{{ $rewiew->rewiew }}</td>
                <td style="width: 20%">{{ $rewiew->user_id }}</td>
                <td style="width: 15%">
                    <a href="{{ route('rewiew.edit', $rewiew->id) }}">Редактировать</a>
                    <form action="{{ route('rewiew.destroy', $rewiew->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="#{{ $rewiew->id }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $rewiews->links('pagination.paginate') }}

@endsection
