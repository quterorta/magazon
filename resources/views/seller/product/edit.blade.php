@extends('layouts/layouts')

@section('title')
"{{ $shop->title }}" | Редактирование товара "{{ $product->title}}"
@endsection

@section('main-content-block')

<h1 class="shop_page__header" style="font-size: 30px;">Редактирование товара "{{ $product->title }}"</h1>
<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('all-shop-products', $shop->id) }}">Все товары</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Изменить товар "{{ $product->title }}"</a></li>
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

<div class="shop_page__form">
    <form action="{{ route('update-shop-product', [$shop->id, $product->id]) }}" method="POST" class="shop_page__shop_form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="chapter_id">Раздел</label>
            <select name="chapter_id" id="chapter_id" class="form-select">
                <option value="0" disabled>--- Выберете раздел ---</option>
                @foreach ($chapters as $chapter)
                <option value="{{ $chapter->id }}" @if ($chapter->id == $product->category->chapter->id) selected @endif>{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="0" disabled>--- Выберете категорию ---</option>
                @foreach ($categories as $category)
                <option value={{ $category->id }} @if ($category->id == $product->category_id) selected @endif>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory_id">Подкатегория</label>
            <select name="sub_category_id" id="subcategory_id" class="form-select">
                <option value="0" disabled>--- Выберете подкатегорию ---</option>
                @foreach ($subcategories as $subcategory)
                <option value={{ $subcategory->id }} @if ($subcategory->id == $product->sub_category_id) selected @endif>{{ $subcategory->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="product_title">Наименование</label>
            <input type="text" name="title" id="product_title" class="form-control" required placeholder="Введите название товара" value="{{ $product->title }}">
        </div>

        <div class="form-group">
            <label for="product_alias">Slug (ЧПУ) (Не изменяйте без необходимости)</label>
            <input type="text" name="alias" id="product_alias" class="form-control" required placeholder="Введите slug товара" value="{{ $product->alias }}">
        </div>
        
        <div class="form-group">
            <label for="product_article">Код товара</label>
            <input type="text" name="article" id="product_article" class="form-control" required placeholder="Введите код товара" value="{{ $product->article }}">
        </div>

        <div class="form-group">
            <label for="product_short_description">Короткое описание</label>
            <textarea name="short_description" id="product_short_description" class="form-control" required placeholder="Введите краткое описание товара">{{ $product->short_description }}</textarea>
        </div>

        <div class="form-group">
            <label for="product_description">Полное описание</label>
            <textarea name="description" id="product_description" class="form-control" required placeholder="Введите полное описание товара">{{ $product->description }}</textarea>
        </div>

        <div class="shop_page__shop_form__select_image_block">
            <h3 class="shop_page__shop_form__select_image_block__header">
                Выберете несколько изображений товара с разных ракурсов<br>
                <i>Обязательна для загрузки только обложка товара</i>
            </h3>
            <div class="shop_page__shop_form__select_image_block__grid">
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_cover) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_cover" @if (null !== $product->image_cover) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Обложка товара</label>
                    <input type="file" name="image_cover" id="product_image_cover">
                </div>
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_1) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_1" @if (null !== $product->image_1) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Изображение товара</label>
                    <input type="file" name="image_1" id="product_image_1">
                </div>
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_2) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_2" @if (null !== $product->image_2) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Изображение товара</label>
                    <input type="file" name="image_2" id="product_image_2">
                </div>
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_3) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_3" @if (null !== $product->image_3) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Изображение товара</label>
                    <input type="file" name="image_3" id="product_image_3">
                </div>
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_4) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_4" @if (null !== $product->image_4) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Изображение товара</label>
                    <input type="file" name="image_4" id="product_image_4">
                </div>
                <div class="shop_page__shop_form_select_image_block__select_image_input" style="background: url({{ Storage::url($product->image_5) }}); background-size: contain; background-position:center; background-repeat: no-repeat;">
                    <label for="product_image_5" @if (null !== $product->image_5) style="top: 100%; transform: translate(-50%, 0%); padding: 1% 0; border: 2px solid #f19b38; font-size: 1.25vw; font-weight: 500; background: #fff; width: 100%; cursor: pointer;" @endif>Изображение товара</label>
                    <input type="file" name="image_5" id="product_image_5">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="foo_select" class="screen-reader-text">Характеристики товара</label>
            <select class="specifications-multiple form-select" id="foo_select" name="specification_id[]" multiple="multiple" style="width: 100%" required>
                @foreach ($specifications as $specification)
                    <option value="{{ $specification->id }}"@foreach($product->specifications as $spec)@if($specification->id == $spec->id)selected @endif @endforeach>{{ $specification->name }} | {{ $specification->value }} {{ $specification->dimension }}</option>
                @endforeach
            </select>
            <div class="">
                <button type="button" id="add_specification" class="btn shop_page__shop_form__add_spec_btn" data-bs-toggle="modal" data-bs-target="#add_specification_modal">
                    Добавить новую характеристику
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="product_price">Цена</label>
            <input type="text" name="price" id="product_price" class="form-control" required placeholder="Введите стоимость товара" value="{{ $product->price }}">
        </div>

        <div class="form-group">
            <label for="product_in_sale">Товар со скидкой</label>
            <select name="product_in_sale" id="product_in_sale" class="form-select">
                <option value=0 @if ($product->product_in_sale == 0) selected @endif>Нет</option>
                <option value=1 @if ($product->product_in_sale == 1) selected @endif>Да</option>
            </select>
        </div>

        <div class="form-group" id="product_new_price_block">
            <label for="product_new_price">Новая цена</label>
            <input type="text" name="new_price" id="product_new_price" class="form-control" placeholder="Введите новую стоимость товара" value="{{ $product->new_price }}">
        </div>

        <div class="form-group">
            <label for="product_loan_terms">Условия кредита</label>
            <textarea name="loan_terms" id="product_loan_terms" class="form-control" placeholder="Опишите условия кредита">{{ $product->loan_terms }}</textarea>
        </div>

        <div class="form-group">
            <label for="product_active">Товар в наличии</label>
            <select name="active" id="product_active" class="form-select">
                <option value=0 @if ($product->active == 0) selected @endif>Нет</option>
                <option value=1 @if ($product->active == 1) selected @endif>Да</option>
            </select>
        </div>

        <div class="form-group d-grid">
            <button type="submit" class="btn btn-success shop_page__shop_form__save_btn">Редактировать товар</button>
        </div>

    </form>
</div>

<!-- МОДАЛЬНОЕ ОКНО ДЛЯ ДОБАВЛЕНИЯ ХАРАКТЕРИСТИКИ ТОВАРА -->
<div class="modal fade" id="add_specification_modal" tabindex="-1" aria-labelledby="shop_page__add_specification_modal_label" aria-hidden="true" class="shop_page__add_specification_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shop_page__add_specification_modal_label">Добавить новую характеристику</h5>
                <button type="button" class="btn-close shop_page__modal__btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('specification.store') }}" method="POST" id="add_specification_form" class="shop_page__modal_form">
                    @csrf

                    <div class="form-group">
                        <label for="chapter_select_for_spec">Выберете раздел</label>
                        <select name="chapter_id_for_spec" id="chapter_select_for_spec" class="form-select">
                            <option value="0" disabled selected>--- Выберете раздел ---</option>
                            @foreach ($chapters as $chapter)
                                <option value={{ $chapter->id }}>{{ $chapter->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_select_for_spec">Выберете категорию</label>
                        <select name="category_id_for_spec" id="category_select_for_spec" class="form-select">
                            <option value="0" disabled selected>--- Выберете категорию ---</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subcategory_select_for_spec">Выберете подкатегорию</label>
                        <select name="subcategory_id_for_spec" id="subcategory_select_for_spec" class="form-select">
                            <option value="0" disabled selected>--- Выберете подкатегорию ---</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name_for_spec">Название характеристики</label>
                        <input type="text" name="name_for_spec" id="name_for_spec" class="form-control" required placeholder="Введите название характеристики">
                    </div>

                    <div class="form-group">
                        <label for="value_for_spec">Значение характеристики</label>
                        <input type="text" name="value_for_spec" id="value_for_spec" class="form-control" required placeholder="Введите значение характеристики">
                    </div>

                    <div class="form-group">
                        <label for="dimension_for_spec">Размерность характеристики (к примеру см, ", л, и т.п.). <i>Необязательно</i></label>
                        <input type="text" name="dimension_for_spec" id="dimension_for_spec" class="form-control" placeholder="Введите размерность характеристики">
                    </div>

                    <div class="form-group">
                        <label class="form-select-label" for="in_filter_for_spec">Характеристика для фильтра</label>
                        <select name="in_filter_for_spec" id="in_filter_for_spec" class="form-select">
                            <option value=0 selected>Нет</option>
                            <option value=1>Да</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" id="add_specification_button" class="btn shop_page__modal_form__save_btn">Сохранить</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_js')
<script>
    $(document).ready(function() {
        if ($('#product_in_sale').val()==1) {
                $('#product_new_price_block').show();
            } else {
                $('#product_new_price_block').hide();
            }

        $('#product_in_sale').change(function() {
            if ($('#product_in_sale').val()==1) {
                $('#product_new_price_block').show();
            } else {
                $('#product_new_price_block').hide();
            }
        });
    });
    //ПОЛУЧЕНИЕ КАТЕГОРИЙ
    $('#chapter_id').change(function() {
        let chapter_sort_id = $('#chapter_id').val().trim();
        $.ajax({
            url: "{{ route('select-category-for-product') }}",
            type: "POST",
            data: {
                chapter_sort_id: chapter_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#category_id').empty();
                $('#subcategory_id').empty();
                $('#subcategory_id').append('<option value="0" disabled selected>--- Выберете подкатегорию ---</option>');
                $('#category_id').append('<option value="0" disabled selected>--- Выберете категорию ---</option>');
                $('#foo_select').empty();
                for (let i = 0; i < data.length; i++) {
                    let category_id = data[i]['id'];
                    let category_title = data[i]['title'];
                    $('#category_id').append('<option value="'+parseInt(category_id)+'">'+category_title+'</option>');
                }
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });
    $('#chapter_select_for_spec').change(function() {
        let chapter_sort_id = $('#chapter_select_for_spec').val().trim();
        $.ajax({
            url: "{{ route('select-category-for-product') }}",
            type: "POST",
            data: {
                chapter_sort_id: chapter_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#category_select_for_spec').empty();
                $('#category_select_for_spec').append('<option value="0" disabled selected>--- Выберете категорию ---</option>');
                $('#subcategory_select_for_spec').empty();
                $('#subcategory_select_for_spec').append('<option value="0" disabled selected>--- Выберете подкатегорию ---</option>');
                for (let i = 0; i < data.length; i++) {
                    let category_id = data[i]['id'];
                    let category_title = data[i]['title'];
                    $('#category_select_for_spec').append('<option value="'+parseInt(category_id)+'">'+category_title+'</option>');
                }
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });
    // ПОЛУЧЕНИЕ ПОДКАТЕГОРИЙ
    $('#category_id').change(function() {
        let category_sort_id = $('#category_id').val().trim();
        $.ajax({
            url: "{{ route('select-subcategory-for-product') }}",
            type: "POST",
            data: {
                category_sort_id: category_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#subcategory_id').empty();
                $('#subcategory_id').append('<option value="0" disabled selected>--- Выберете подкатегорию ---</option>');
                for (let i = 0; i < data.length; i++) {
                    let subcategory_id = data[i]['id'];
                    let subcategory_title = data[i]['title'];
                    $('#subcategory_id').append('<option value="'+parseInt(subcategory_id)+'">'+subcategory_title+'</option>');
                }
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });
    $('#category_select_for_spec').change(function() {
        let category_sort_id = $('#category_select_for_spec').val().trim();
        $.ajax({
            url: "{{ route('select-subcategory-for-product') }}",
            type: "POST",
            data: {
                category_sort_id: category_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#subcategory_select_for_spec').empty();
                $('#subcategory_select_for_spec').append('<option value="0" disabled selected>--- Выберете подкатегорию ---</option>');
                for (let i = 0; i < data.length; i++) {
                    let subcategory_id = data[i]['id'];
                    let subcategory_title = data[i]['title'];
                    $('#subcategory_select_for_spec').append('<option value="'+parseInt(subcategory_id)+'">'+subcategory_title+'</option>');
                }
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });
    // ПОЛУЧЕНИЕ ХАРАКТЕРИСТИК ДЛЯ ПОДКАТЕГОРИЙ
    $('#subcategory_id').change(function() {
        let subcategory_sort_id = $('#subcategory_id').val().trim();
        $.ajax({
            url: "{{ route('select-specifications-for-product') }}",
            type: "POST",
            data: {
                subcategory_sort_id: subcategory_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                console.log(data);
                $('#foo_select').empty();
                for (let i = 0; i < data.length; i++) {
                    let specification_id = data[i]['id'];
                    let specification_name = data[i]['name'];
                    let specification_value = data[i]['value'];
                    let specification_dimension = data[i]['dimension'];
                    if (specification_dimension == null) {
                        $('#foo_select').append('<option value="'+parseInt(specification_id)+'">'+specification_name+' | '+ specification_value+'</option>');
                    } else {
                        $('#foo_select').append('<option value="'+parseInt(specification_id)+'">'+specification_name+' | '+ specification_value+' '+specification_dimension+'</option>');
                    }
                }
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });
    // ПОКАЗ МИНИАТЮРЫ ИЗОБРАЖЕНИЙ ПОСЛЕ ЗАГРУЗКИ
    $("#product_image_cover").change(function () {
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_cover').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_cover').parent().css("backgroundPosition", "center");
                $('#product_image_cover').parent().css("backgroundSize", "contain");
                $('#product_image_cover').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_cover').parent().children('label').css('top', '100%');
                $('#product_image_cover').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_cover').parent().children('label').css('padding', '1% 0');
                $('#product_image_cover').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_cover').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_cover').parent().children('label').css('fontWeight', '500');
                $('#product_image_cover').parent().children('label').css('background', '#fff');
                $('#product_image_cover').parent().children('label').css('width', '100%');
                $('#product_image_cover').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_1").change(function () {
        readURL1(this);
    });
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_1').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_1').parent().css("backgroundPosition", "center");
                $('#product_image_1').parent().css("backgroundSize", "contain");
                $('#product_image_1').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_1').parent().children('label').css('top', '100%');
                $('#product_image_1').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_1').parent().children('label').css('padding', '1% 0');
                $('#product_image_1').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_1').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_1').parent().children('label').css('fontWeight', '500');
                $('#product_image_1').parent().children('label').css('background', '#fff');
                $('#product_image_1').parent().children('label').css('width', '100%');
                $('#product_image_1').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_2").change(function () {
        readURL2(this);
    });
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_2').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_2').parent().css("backgroundPosition", "center");
                $('#product_image_2').parent().css("backgroundSize", "contain");
                $('#product_image_2').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_2').parent().children('label').css('top', '100%');
                $('#product_image_2').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_2').parent().children('label').css('padding', '1% 0');
                $('#product_image_2').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_2').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_2').parent().children('label').css('fontWeight', '500');
                $('#product_image_2').parent().children('label').css('background', '#fff');
                $('#product_image_2').parent().children('label').css('width', '100%');
                $('#product_image_2').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_3").change(function () {
        readURL3(this);
    });
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_3').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_3').parent().css("backgroundPosition", "center");
                $('#product_image_3').parent().css("backgroundSize", "contain");
                $('#product_image_3').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_3').parent().children('label').css('top', '100%');
                $('#product_image_3').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_3').parent().children('label').css('padding', '1% 0');
                $('#product_image_3').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_3').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_3').parent().children('label').css('fontWeight', '500');
                $('#product_image_3').parent().children('label').css('background', '#fff');
                $('#product_image_3').parent().children('label').css('width', '100%');
                $('#product_image_3').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_4").change(function () {
        readURL4(this);
    });
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_4').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_4').parent().css("backgroundPosition", "center");
                $('#product_image_4').parent().css("backgroundSize", "contain");
                $('#product_image_4').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_4').parent().children('label').css('top', '100%');
                $('#product_image_4').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_4').parent().children('label').css('padding', '1% 0');
                $('#product_image_4').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_4').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_4').parent().children('label').css('fontWeight', '500');
                $('#product_image_4').parent().children('label').css('background', '#fff');
                $('#product_image_4').parent().children('label').css('width', '100%');
                $('#product_image_4').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_5").change(function () {
        readURL5(this);
    });
    function readURL5(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_5').parent().css("background", "url('"+e.target.result+"')");
                $('#product_image_5').parent().css("backgroundPosition", "center");
                $('#product_image_5').parent().css("backgroundSize", "contain");
                $('#product_image_5').parent().css("backgroundRepeat", "no-repeat");

                $('#product_image_5').parent().children('label').css('top', '100%');
                $('#product_image_5').parent().children('label').css('transform', 'translate(-50%, 0%)');
                $('#product_image_5').parent().children('label').css('padding', '1% 0');
                $('#product_image_5').parent().children('label').css('border', '2px solid #f19b38');
                $('#product_image_5').parent().children('label').css('fontSize', '1.25vw');
                $('#product_image_5').parent().children('label').css('fontWeight', '500');
                $('#product_image_5').parent().children('label').css('background', '#fff');
                $('#product_image_5').parent().children('label').css('width', '100%');
                $('#product_image_5').parent().children('label').css('cursor', 'pointer');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    //ДОБАВЛЕНИЕ ХАРАКТЕРИСТИКИ В МОДАЛЬНОМ ОКНЕ
    $('#add_specification_button').click(function() {
        let addSpecificationModalWindow = $('#add_specification_modal');
        let subcategory_id_for_spec = $('#subcategory_select_for_spec').val();
        let name_for_spec = $('#name_for_spec').val();
        let value_for_spec = $('#value_for_spec').val();
        let dimension_for_spec = $('#dimension_for_spec').val();
        let in_filter_for_spec = $('#in_filter_for_spec').val();
        $.ajax({
            url: "{{ route('add-specification-by-modal-window') }}",
            type: "POST",
            data: {
                subcategory_id_for_spec: subcategory_id_for_spec, name_for_spec: name_for_spec, value_for_spec: value_for_spec, dimension_for_spec: dimension_for_spec, in_filter_for_spec: in_filter_for_spec
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                let specification_id = data['id'];
                let specification_name = data['name'];
                let specification_value = data['value'];
                let specification_dimension = data['dimension'];
                if (specification_dimension == null) {
                    $('#foo_select').append('<option value="'+parseInt(specification_id)+'">'+specification_name+' | '+ specification_value+'</option>');
                } else {
                    $('#foo_select').append('<option value="'+parseInt(specification_id)+'">'+specification_name+' | '+ specification_value+' '+specification_dimension+'</option>');
                }
                alert('Характеристика успешно добавлена!');
                addSpecificationModalWindow.modal('hide');
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
                alert('Характеристика уже существует, воспользуйтесь поиском!');
            }
        });
    });

</script>
@endsection
