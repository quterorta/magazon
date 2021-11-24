@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All cities')

@section('main-admin-content')
    <h1>Все города доставки</h1>

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
                <th style="width: 20%">Country</th>
                <th style="width: 20%">Region</th>
                <th style="width: 20%">City</th>
                <th style="width: 30%">Controls</th>
            </tr>
            @foreach ($cities as $city)
            <tr>
                <td style="width: 10%">{{ $city->id }}</td>
                <td style="width: 20%">{{ $city->region->country->title }}</td>
                <td style="width: 20%">{{ $city->region->title }}</td>
                <td style="width: 20%"><b>{{ $city->title }}</b></td>
                <td style="width: 30%">
                    <a href="{{ route('city.edit', $city->id) }}">Редактировать</a>
                    <form action="{{ route('city.destroy', $city->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $city->title }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $cities->links('pagination.paginate') }}

@endsection
