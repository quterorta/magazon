@extends('layouts/layouts')

@section('title')
Редактирование магазина "{{ $shop->title }}"
@endsection

@section('main-content-block')

<h1 class="shop__header">Изменить магазин "{{ $shop->title }}"</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Редактирование</a></li>
    </ul>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (isset($errors))
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ $error }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach
@endif

<div class="shop-create-block">
    <form action="{{ route('update-shop', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="shop_title">Название магазина</label>
            <input type="text" name="title" id="shop_title" class="form-control" required placeholder="Введите название магазина" value="{{ $shop->title }}">
        </div>
        <div class="form-group">
            <label for="shop_slug">ЧПУ (название магазина в адрессной строке, без необходимости не изменяйте)</label>
            <input type="text" name="slug" id="shop_slug" class="form-control" required placeholder="Slug" value="{{ $shop->slug }}">
        </div>
        <div class="form-group" id="banner_image_upload_field_block" style="background: url({{ Storage::url($shop->banner_image) }}); ">
            <label for="shop_banner_image" id="shop_banner_image_label"><b id="shop_banner_image_label_b">Обложка магазина</b><br>Нажмите чтобы выбрать файл</label>
            <input type="file" name="banner_image" id="shop_banner_image" class="form-control">
        </div>
        <div class="form-group d-grid mb-3">
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
        </div>
    </form>
</div>

@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $('#banner_image_upload_field_block').css("backgroundPosition", "center");
            $('#banner_image_upload_field_block').css("backgroundSize", "contain");
            $('#banner_image_upload_field_block').css("backgroundRepeat", "no-repeat");

            $('#shop_banner_image_label').css('top', '100%');
            $('#shop_banner_image_label').css('transform', 'translate(-50%, -100%)');
            $('#shop_banner_image_label').css('padding', '1% 0');
            $('#shop_banner_image_label').css('border', '1px solid black');
            $('#shop_banner_image_label_b').css('fontSize', '1vw');
            $('#shop_banner_image_label').css('fontSize', '0.75vw');
            $('#shop_banner_image_label').css('background', '#fff');

            $("#shop_banner_image").change(function () {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#banner_image_upload_field_block').css("background", "url('"+e.target.result+"')");
                        $('#banner_image_upload_field_block').css("backgroundPosition", "center");
                        $('#banner_image_upload_field_block').css("backgroundSize", "contain");
                        $('#banner_image_upload_field_block').css("backgroundRepeat", "no-repeat");

                        $('#shop_banner_image_label').css('top', '100%');
                        $('#shop_banner_image_label').css('transform', 'translate(-50%, 2.5%)');
                        $('#shop_banner_image_label').css('padding', '1% 0');
                        $('#shop_banner_image_label').css('border', '1px solid black');
                        $('#shop_banner_image_label_b').css('fontSize', '1vw');
                        $('#shop_banner_image_label').css('fontSize', '0.75vw');
                        $('#shop_banner_image_label').css('background', '#fff');
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endsection
