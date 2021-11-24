@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit country "{{ $country->title }}"
@endsection

@section('main-admin-content')
    <h1>Редактировать страну "{{ $country->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('country.update', $country->id) }}" method="POST" class="admin-create-items-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="country_title">Страна</label>
            <input type="text" name='title' placeholder="Введите название страны" required class="form-control" id="country_title" value="{{ $country->title }}">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Редактировать страну</button>
        </div>
    </form>

@endsection
