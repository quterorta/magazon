@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add chapter')

@section('main-admin-content')
    <h1>Добавить раздел</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('chapter.store') }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="chapter_title">Название раздела</label>
            <input type="text" name='title' placeholder="Введите название раздела" required class="form-control" id="chapter_title">
        </div>
        <div class="form-group">
            <label for="chapter_alias">Slug раздела</label>
            <input type="text" name='alias' placeholder="Введите slug раздела" required class="form-control" id="chapter_alias">
        </div>
        <div class="form-group">
            <label for="chapter_image">Изображение для раздела</label>
            <input type="file" name='image' placeholder="Выберите изображение для раздела" required class="form-control" id="chapter_image">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Добавить раздел</button>
        </div>
    </form>

@endsection
