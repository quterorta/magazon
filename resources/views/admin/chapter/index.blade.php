@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All chapters')

@section('main-admin-content')
    <h1>Все разделы</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-chapters-list">
        @foreach ($chapters as $chapter)
            <div class="admin-chapter-item" style="display: grid; grid-template-columns: 0.5fr 5fr 2fr;">
                <h3>{{ $chapter->id }}</h3>
                <h3>{{ $chapter->title }}</h3>
                <div class="admin-control-links">
                    <a href="{{ route('chapter.edit', $chapter->id) }}">Редактировать</a>
                    <form action="{{ route('chapter.destroy', $chapter->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $chapter->title }}">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{ $chapters->links('pagination.paginate') }}

@endsection
