@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add category')

@section('main-admin-content')
    <h1>Добавить категорию</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('category.store') }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="chapter_title">Выберете раздел</label>
            <select name="chapter_id" id="category_chapter_id" class="form-select">
                <option value="0" disabled selected>--- Выберете раздел ---</option>
                @foreach ($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="chapter_title">Название категории</label>
            <input type="text" name='title' placeholder="Введите название категории" required class="form-control" id="category_title">
        </div>
        <div class="form-group">
            <label for="chapter_title">Изображение для категории</label>
            <input type="file" name='image' placeholder="Выберете изображение для категории" required class="form-control" id="chapter_image">
        </div>

        <div class="form-group">
            <label for="chapter_title">Slug категории (ЧПУ)</label>
            <input type="text" name='alias' placeholder="Slug категории" required class="form-control" id="category_alias">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Добавить категорию</button>
        </div>
    </form>

@endsection
