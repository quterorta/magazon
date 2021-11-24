@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All users')

@section('main-admin-content')
    <h1>Все пользователи</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-subcategory-list">
        <div class="admin-subcategory-item" style="display: grid; grid-template-columns: 0.5fr 2fr 2fr 2fr 1fr;">
            <p><b>ID</b></p>
            <p><b>Name</b></p>
            <p><b>Role</b></p>
            <p><b>Controll</b></p>
        </div>
        <hr>
        @foreach ($users as $user)
            <div class="admin-subcategory-item" style="display: grid; grid-template-columns: 0.5fr 2fr 2fr 2fr 1fr;">
                <p>{{ $user->id }}</p>
                <p><i>{{ $user->name }}</i></p>
                <p><i>{{ $user->roles->first()->name }}</i></p>
                <div class="admin-control-links">
                    <a href="{{ route('user.edit', $user->id) }}">Редактировать</a>
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="Пользователь #{{ $user->id }}">Удалить</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    {{ $users->links('pagination.paginate') }}

@endsection
