@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add country')

@section('main-admin-content')
    <h1>Добавить страну доставки</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('country.store') }}" method="POST" class="admin-create-items-form">
        @csrf
        <div class="form-group">
            <label for="country_title">Страна</label>
            <input type="text" name='title' placeholder="Введите название страны" required class="form-control" id="country_title">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Добавить страну</button>
        </div>
    </form>

@endsection
