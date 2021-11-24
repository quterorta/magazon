@extends('layouts/layouts')

@section('title', 'Создать магазин')

@section('main-content-block')

<h1 class="shop__header">Создать магазин</h1>

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
    <form action="{{ route('store-shop') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="shop_title">Название магазина</label>
            <input type="text" name="title" id="shop_title" class="form-control" required placeholder="Введите название магазина">
        </div>
        <div class="form-group">
            <label for="shop_slug">ЧПУ (название магазина в адрессной строке, без необходимости не изменяйте)</label>
            <input type="text" name="slug" id="shop_slug" class="form-control" required placeholder="Slug">
        </div>
        <div class="form-group" id="banner_image_upload_field_block">
            <label for="shop_banner_image" id="shop_banner_image_label"><b id="shop_banner_image_label_b">Обложка магазина</b><br>Нажмите чтобы выбрать файл</label>
            <input type="file" name="banner_image" id="shop_banner_image" class="form-control" required>
        </div>
        <div class="form-group d-grid mb-3">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>

@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
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
                        $('#shop_banner_image_label').css('transform', 'translate(-50%, -100%)');
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
