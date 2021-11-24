@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Create user')

@section('main-admin-content')
    <h1>Добавить пользователя</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div>
        <form action="{{ route('user.store') }}" method="POST" class="">
            @csrf
            <div class="form-group">
                <label for="user_email">E-mail</label>
                <input type="email" name="email" id="user_email" class="form-control" required placeholder="Введите e-mail">
            </div>
            <div class="form-group">
                <label for="user_password">Пароль</label>
                <input type="password" name="password" id="user_password" class="form-control" required placeholder="Введите пароль">
            </div>
            <div class="form-group">
                <label for="user_name">Имя пользователя</label>
                <input type="text" name="name" id="user_name" class="form-control" required placeholder="Введите имя пользователя">
            </div>
            <div class="form-group">
                <label for="user_last_name">Фамилия пользователя</label>
                <input type="text" name="last_name" id="user_last_name" class="form-control" required placeholder="Введите фамилию пользователя">
            </div>
            <div class="form-group">
                <label for="user_phone_number">Номер телефона</label>
                <input type="text" name="phone_number" id="user_phone_number" class="form-control" required placeholder="Введите номер телефона">
            </div>
            <div class="form-group">
                <p class="form-input-block-mini-header">Роль пользователя</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_role" id="user_role_0" value=0>
                    <label class="form-check-label" for="user_role_0">Покупатель</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_role" id="user_role_1" value=1>
                    <label class="form-check-label" for="user_role_1">Продавец</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_role" id="user_role_2" value=2>
                    <label class="form-check-label" for="user_role_2">Администратор</label>
                </div>
            </div>
            <div class="form-group d-grid">
                <button type="submit" class="btn btn-success">Добавить пользователя</button>
            </div>
        </form>
    </div>

@endsection
