@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All regions')

@section('main-admin-content')
    <h1>Все регионы доставки</h1>

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
                <th style="width: 30%">Country</th>
                <th style="width: 30%">Region</th>
                <th style="width: 30%">Controls</th>
            </tr>
            @foreach ($regions as $region)
            <tr>
                <td style="width: 10%">{{ $region->id }}</td>
                <td style="width: 30%">{{ $region->country->title }}</td>
                <td style="width: 30%">{{ $region->title }}</td>
                <td style="width: 30%">
                    <a href="{{ route('region.edit', $region->id) }}">Редактировать</a>
                    <form action="{{ route('region.destroy', $region->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $region->title }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $regions->links('pagination.paginate') }}

@endsection
