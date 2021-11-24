@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All subcategories')

@section('main-admin-content')
    <h1>Все подкатегории</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-subcategory-list">
        @foreach ($subcategories as $subcategory)
            <hr>
            <div class="admin-subcategory-item" style="display: grid; grid-template-columns: 0.5fr 2fr 2fr 2fr 1fr;">
                <p>{{ $subcategory->id }}</p>
                <p>
                    <i>{{ $subcategory->category->chapter->title }}</i><br>
                    <i>{{ $subcategory->category->title }}</i><br>
                    {{ $subcategory->title }}
                </p>
                <img src="{{ Storage::url($subcategory->image) }}" alt="" height="100px">
                <p>{{ $subcategory->alias }}</p>
                <div class="admin-control-links">
                    <a href="{{ route('subcategory.edit', $subcategory->id) }}">Редактировать</a>
                    <form action="{{ route('subcategory.destroy', $subcategory->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $subcategory->title }}">Удалить</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    {{ $subcategories->links('pagination.paginate') }}

@endsection
