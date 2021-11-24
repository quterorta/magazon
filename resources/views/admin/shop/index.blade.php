@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All shops')

@section('main-admin-content')
    <h1>Все продавцы (магазины)</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-subcategory-list">
        <table style="width: 100%">
            <tr>
                <th style="width: 7.5%">ID</th>
                <th style="width: 17.5%">Название</th>
                <th style="width: 17.5%">Баннер</th>
                <th style="width: 17.5%">Подтвержденный</th>
                <th style="width: 17.5%">Пользователь</th>
                <th style="width: 22.5%">Controls</th>
            </tr>
            @foreach ($shops as $shop)
            <tr>
                <td style="width: 7.5%">{{ $shop->id }}</td>
                <td style="width: 17.5%">{{ $shop->title }}</td>
                <td style="width: 17.5%"><img src="{{ Storage::url($shop->banner_image) }}" alt="" width="100%"></td>
                <td style="width: 17.5%">@if ($shop->official_saller === 1) Да @else Нет @endif</td>
                <td style="width: 17.5%">{{ $shop->user->email }}</td>
                <td style="width: 22.5%">
                    <a href="{{ route('shop.edit', $shop->id) }}">Редактировать</a><br>
                    <a href="{{ route('shop.show', $shop->id) }}">Товары</a>
                    <form action="{{ route('shop.destroy', $shop->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $shop->title }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $shops->links('pagination.paginate') }}

@endsection
