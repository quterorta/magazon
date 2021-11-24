@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit shop "{{ $shop->title }}"
@endsection

@section('main-admin-content')
    <h1>Редактировать магазин "{{ $shop->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div>
        <form action="{{ route('shop.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="shop_title">Название магазина</label>
                <input type="text" name="title" id="shop_title" class="form-control" required placeholder="Введите название магазина" value="{{ $shop->title }}">
            </div>
            <div class="form-group">
                <label for="shop_alias">Slug(ЧПУ) магазина</label>
                <input type="text" name="alias" id="shop_alias" class="form-control" required placeholder="Введите slug магазина" value="{{ $shop->slug }}">
            </div>
            <div class="form-group">
                <label for="shop_image_banner">Баннер для магазина</label>
                <img src="{{ Storage::url($shop->banner_image) }}" alt="" id="image_banner" height="150px" style="display: block;">
                <input type="file" name="banner-image" id="shop_image_banner" class="form-control" placeholder="Выберете файл">
            </div>
            <div class="form-group">
                <label for="shop_official_seller">Официальный продавец (Подтвержденный аккаунт)</label>
                <select name="official_seller" id="shop_official_seller" class="form-select">
                    <option value=0 @if ( $shop->official_saller == 0) selected @endif>Нет</option>
                    <option value=1 @if ( $shop->official_saller == 1) selected @endif>Да</option>
                </select>
            </div>
            <div class="form-group">
                <label for="shop_user_id">Владелец (пользователь)</label>
                <select name="user_id" id="shop_user_id" class="form-select">

                    <option value=0 disabled>--- Выберете пользователя ---</option>
                    @foreach ($users as $user)
                    <option value={{ $user->id }} @if ( $shop->user->id == $user->id) selected @endif>{{ $user->email }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group d-grid">
                <button type="submit" class="btn btn-success">Редактировать магазин</button>
            </div>
        </form>
    </div>



@endsection

@section('custom-admin-js')
    <script>
        function readURL_cover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_banner').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#shop_image_banner").change(function () {
            readURL_cover(this);
        });
    </script>
@endsection
