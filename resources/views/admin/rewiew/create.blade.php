@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add review')

@section('main-admin-content')
    <h1>Добавить отзыв</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div>
        <form action="{{ route('rewiew.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_id">Товар</label>
                <select name="product_id" id="product_id" class="specifications-multiple form-select">
                    <option value=0 disabled selected>--- Выберете товар ---</option>
                    @foreach ($products as $product)
                    <option value={{ $product->id }}>{{ $product->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="">Оценка</label>
                <div class="rating rating_set">
                    <div class="rating__body">
                        <div class="rating__active"></div>
                        <div class="rating__items">
                            <input type="radio" name="rating" class="rating__item" value=1 required>
                            <input type="radio" name="rating" class="rating__item" value=2 required>
                            <input type="radio" name="rating" class="rating__item" value=3 required>
                            <input type="radio" name="rating" class="rating__item" value=4 required>
                            <input type="radio" name="rating" class="rating__item" value=5 required>
                            <div class="rating__value">0.0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="rewiew">Отзыв</label>
                <textarea name="rewiew" id="rewiew" class="form-control" placeholder="Введите текст отзыва" required></textarea>
            </div>

            <div class="form-group">
                <label for="user_id">Пользователь</label>
                <select name="user_id" id="user_id" class="form-select">
                    <option value=0 disabled selected>--- Выберете пользователя ---</option>
                    @foreach ($users as $user)
                    <option value={{ $user->id }}>{{ $user->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group d-grid">
                <button class="btn btn-success" type="submit">Добавить отзыв</button>
            </div>
        </form>
    </div>

@endsection
