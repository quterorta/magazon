@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All categories')

@section('main-admin-content')
    <h1>Все категории</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-category-list">
        @foreach ($categories as $category)
            <hr>
            <div class="admin-category-item" style="display: grid; grid-template-columns: 0.5fr 2fr 2fr 2fr 1fr;">
                <p>{{ $category->id }}</p>
                <p>
                    <i>{{ $category->chapter->title }}</i><br>
                    {{ $category->title }}
                </p>
                <img src="{{ Storage::url($category->image) }}" alt="" height="100px">
                <p>{{ $category->alias }}</p>
                <div class="admin-control-links">
                    <a href="{{ route('category.edit', $category->id) }}">Редактировать</a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $category->title }}">Удалить</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    {{ $categories->links('pagination.paginate') }}

@endsection
