@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit region "{{ $region->title }}"
@endsection

@section('main-admin-content')
    <h1>Редактировать регион "{{ $region->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('region.update', $region->id) }}" method="POST" class="admin-create-items-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="region_title">Страна</label>
            <select name="country_id" id="region_country_id" class="form-select" required>
                <option value="0" disabled>--- Выберете страну ---</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}"@if ($country->id == $region->country->id) selected @endif>{{ $country->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="region_title">Регион</label>
            <input type="text" name='title' placeholder="Введите название региона" required class="form-control" id="region_title" value="{{ $region->title }}">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Редактировать регион</button>
        </div>
    </form>

@endsection
