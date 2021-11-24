@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add product')

@section('main-admin-content')
    <h1>Добавить товар</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div>
        <form action="{{ route('product.store') }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="chapter_id">Раздел</label>
                <select name="chapter_id" id="chapter_id" class="form-select">
                    <option value="0" disabled selected>--- Выберете раздел ---</option>
                    @foreach ($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Категория</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="0" disabled selected>--- Выберете категорию ---</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subcategory_id">Подкатегория</label>
                <select name="sub_category_id" id="subcategory_id" class="form-select">
                    <option value="0" disabled selected>--- Выберете подкатегорию ---</option>
                </select>
            </div>

            <div class="form-group">
                <label for="product_title">Наименование</label>
                <input type="text" name="title" id="product_title" class="form-control" required placeholder="Введите название товара">
            </div>

            <div class="form-group">
                <label for="product_alias">Slug (ЧПУ)</label>
                <input type="text" name="alias" id="product_alias" class="form-control" required placeholder="Введите алиас товара">
            </div>
            
            <div class="form-group">
                <label for="product_article">Код товара</label>
                <input type="text" name="article" id="product_article" class="form-control" required placeholder="Введите код товара">
            </div>

            <div class="form-group">
                <label for="product_short_description">Короткое описание</label>
                <textarea name="short_description" id="product_short_description" class="form-control" required placeholder="Введите краткое описание товара"></textarea>
            </div>

            <div class="form-group">
                <label for="product_description">Полное описание</label>
                <textarea name="description" id="product_description" class="form-control" required placeholder="Введите полное описание товара"></textarea>
            </div>

            <div class="form-group">
                <label for="product_image_cover">Обложка товара</label>
                <img src="" id="image_cover" alt="Обложка товара" style="display: none; height: 100px;">
                <input type="file" name="image_cover" id="product_image_cover" class="form-control" required placeholder="Выберете изображение для обложки товара">
            </div>

            <div class="form-group">
                <label for="product_image_1">Изображение товара</label>
                <img src="" id="image_1" alt="Изображение товара" style="display: none; height: 100px;">
                <input type="file" name="image_1" id="product_image_1" class="form-control" placeholder="Выберете изображение товара">
            </div>

            <div class="form-group">
                <label for="product_image_2">Изображение товара</label>
                <img src="" id="image_2" alt="Изображение товара" style="display: none; height: 100px;">
                <input type="file" name="image_2" id="product_image_2" class="form-control" placeholder="Выберете изображение товара">
            </div>

            <div class="form-group">
                <label for="product_image_3">Изображение товара</label>
                <img src="" id="image_3" alt="Изображение товара" style="display: none; height: 100px;">
                <input type="file" name="image_3" id="product_image_3" class="form-control" placeholder="Выберете изображение товара">
            </div>

            <div class="form-group">
                <label for="product_image_4">Изображение товара</label>
                <img src="" id="image_4" alt="Изображение товара" style="display: none; height: 100px;">
                <input type="file" name="image_4" id="product_image_4" class="form-control" placeholder="Выберете изображение товара">
            </div>

            <div class="form-group">
                <label for="product_image_5">Изображение товара</label>
                <img src="" id="image_5" alt="Изображение товара" style="display: none; height: 100px;">
                <input type="file" name="image_5" id="product_image_5" class="form-control" placeholder="Выберете изображение товара">
            </div>

            <div class="form-group">
                <label for="foo_select" class="screen-reader-text">Характеристики товара <i>(для множественного выбора воспользуйтесь клавишами 'Shift' и 'Ctrl')</i></label>
                <select class="specifications-multiple form-select" id="foo_select" name="specification_id[]" multiple="multiple" style="width: 100%" required>
                    @foreach ($specifications as $specification)
                        <option value={{ $specification->id }}>{{ $specification->name }} | {{ $specification->value }} {{ $specification->dimension }}</option>
                    @endforeach
                </select>
                <div class="">
                    <button type="button" id="add_specification" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_specification_modal">
                        Добавить новую характеристику
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="shop_id">Продавец</label>
                <select name="shop_id" id="shop_id" class="form-select">
                    <option value="0" disable>--- Выберете продавца ---</option>
                    @foreach ($shops as $shop)
                    <option value={{ $shop->id }}>{{ $shop->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="product_price">Цена</label>
                <input type="text" name="price" id="product_price" class="form-control" required placeholder="Введите стоимость товара">
            </div>

            <div class="form-group">
                <label for="product_in_sale">Товар со скидкой</label>
                <select name="product_in_sale" id="product_in_sale" class="form-select">
                    <option value=0 selected>Нет</option>
                    <option value=1>Да</option>
                </select>
            </div>

            <div class="form-group" id="product_new_price_block">
                <label for="product_new_price">Новая цена</label>
                <input type="text" name="new_price" id="product_new_price" class="form-control" placeholder="Введите новую стоимость товара">
            </div>

            <div class="form-group">
                <label for="product_loan_terms">Условия кредита</label>
                <textarea name="loan_terms" id="product_loan_terms" class="form-control" placeholder="Опишите условия кредита"></textarea>
            </div>

            <div class="form-group">
                <label for="product_active">Активный товар</label>
                <select name="active" id="product_active" class="form-select">
                    <option value=0 selected>Нет</option>
                    <option value=1>Да</option>
                </select>
            </div>

            <div class="form-group">
                <label for="product_moderate">Товар прошел модерацию</label>
                <select name="moderate" id="product_moderate" class="form-select">
                    <option value=0 selected>Нет</option>
                    <option value=1>Да</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="recommended">Рекомендованный товар</label>
                <select name="recommended" id="product_recommended" class="form-select">
                    <option value=0 selected>Нет</option>
                    <option value=1>Да</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="popular">Популярный товар</label>
                <select name="popular" id="popular" class="form-select">
                    <option value=0 selected>Нет</option>
                    <option value=1>Да</option>
                </select>
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="btn btn-success">Добавить товар</button>
            </div>

        </form>
    </div>

<!-- МОДАЛЬНОЕ ОКНО ДЛЯ ДОБАВЛЕНИЯ ХАРАКТЕРИСТИКИ ТОВАРА -->
    <div class="modal fade" id="add_specification_modal" tabindex="-1" aria-labelledby="add_specification_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_specification_modal_label">Добавить новую характеристику</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('specification.store') }}" method="POST" id="add_specification_form">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" id="add_specification_button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-admin-js')
<script>
    $(document).ready(function() {
        $('#product_new_price_block').hide();

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
                $('#category_id').append('<option value="0" disabled selected>--- Выберете категорию ---</option>');
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
    function readURL_cover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_cover').css("display","block");
                $('#image_cover').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL_1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_1').css("display","block");
                $('#image_1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL_2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_2').css("display","block");
                $('#image_2').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL_3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_3').css("display","block");
                $('#image_3').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL_4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_4').css("display","block");
                $('#image_4').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL_5(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_5').css("display","block");
                $('#image_5').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product_image_cover").change(function () {
        readURL_cover(this);
    });
    $("#product_image_1").change(function () {
        readURL_1(this);
    });
    $("#product_image_2").change(function () {
        readURL_2(this);
    });
    $("#product_image_3").change(function () {
        readURL_3(this);
    });
    $("#product_image_4").change(function () {
        readURL_4(this);
    });
    $("#product_image_5").change(function () {
        readURL_5(this);
    });

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
