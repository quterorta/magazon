@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit chapter {{ $chapter->title }}
@endsection

@section('main-admin-content')
    <h1>Редактировать раздел "{{ $chapter->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('chapter.update', $chapter->id) }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="chapter_title">Название раздела</label>
            <input type="text" name='title' placeholder="Введите название раздела" value="{{ $chapter->title }}" required class="form-control" id="chapter_title">
        </div>
        <div class="form-group">
            <label for="chapter_alias">Slug раздела</label>
            <input type="text" name='alias' placeholder="Введите slug раздела" value="{{ $chapter->alias }}" required class="form-control" id="chapter_title">
        </div>
        <div class="form-group">
            <label for="chapter_image">Изображение раздела</label>
            @if (null !== $chapter->image)<img src="{{ Storage::url($chapter->image) }}" alt="" style="display: block; height: 70px;">@endif
            <input type="file" name='image' placeholder="Выберете изображение для раздела" class="form-control" id="chapter_image">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Редактировать раздел</button>
        </div>
    </form>

@endsection
