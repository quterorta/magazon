@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All countries')

@section('main-admin-content')
    <h1>Все страны доставки</h1>

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
                <th style="width: 60%">Country</th>
                <th style="width: 30%">Controls</th>
            </tr>
            @foreach ($countries as $country)
            <tr>
                <td style="width: 10%">{{ $country->id }}</td>
                <td style="width: 60%">{{ $country->title }}</td>
                <td style="width: 30%">
                    <a href="{{ route('country.edit', $country->id) }}">Редактировать</a>
                    <form action="{{ route('country.destroy', $country->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $country->title }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $countries->links('pagination.paginate') }}

@endsection
