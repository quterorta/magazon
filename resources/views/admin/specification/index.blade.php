@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All specifications')

@section('main-admin-content')
    <h1>Все характеристики</h1>

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
                <th style="width: 17%">Подкатегория</th>
                <th style="width: 17%">Наименование</th>
                <th style="width: 17%">Значение</th>
                <th style="width: 17%">Размерность</th>
                <th style="width: 17%">В фильтре</th>
                <th style="width: 10%">Controls</th>
            </tr>
            @foreach ($specifications as $specification)
            <tr>
                <td style="width: 5%">{{ $specification->id }}</td>
                <td style="width: 17%"><i>{{ $specification->sub_category->category->title}}</i>
                    <br>{{ $specification->sub_category->title }}
                </td>
                <td style="width: 17%">{{ $specification->name }}</td>
                <td style="width: 17%">{{ $specification->value }}</td>
                <td style="width: 17%">{{ $specification->dimension }}</td>
                <td style="width: 17%">@if ( $specification->in_filter == 0) Нет @else Да @endif</td>
                <td style="width: 10%">
                    <a href="{{ route('specification.edit', $specification->id) }}">Редактировать</a>
                    <form action="{{ route('specification.destroy', $specification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $specification->name }} | {{ $specification->value }} @if(null !== $specification->dimension){{ $specification->dimension}} @endif">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $specifications->links('pagination.paginate') }}

@endsection
