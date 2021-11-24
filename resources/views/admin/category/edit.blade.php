@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit category {{ $category->title }}
@endsection

@section('main-admin-content')
    <h1>Редактировать категорию "{{ $category->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST" class="admin-create-items-form"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="chapter_title">Выберете раздел</label>
            <select name="chapter_id" id="category_chapter_id" class="form-select">
                <option value="0" disabled>--- Выберете раздел ---</option>
                @foreach ($chapters as $chapter)
                    <option value="{{ $chapter->id }}" @if ($chapter->id == $category->chapter->id) selected @endif>{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="category_title">Название категории</label>
            <input type="text" name='title' placeholder="Введите название категории" required class="form-control" id="category_title" value="{{ $category->title }}">
        </div>
        <div class="form-group">
            <label for="category_image">Изображение для категории</label>
            <img src="{{ Storage::url($category->image) }}" alt="" height="100px" style="display: block">
            <input type="file" name='image' placeholder="Выберете изображение для категории" class="form-control" id="category_image">
        </div>

        <div class="form-group">
            <label for="category_alias">Slug категории (ЧПУ)</label>
            <input type="text" name='alias' placeholder="Slug категории" required class="form-control" id="category_alias" value="{{ $category->alias }}">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Редактировать категорию</button>
        </div>
    </form>

@endsection
