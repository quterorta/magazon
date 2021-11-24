@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add specifications')

@section('main-admin-content')
    <h1>Добавить характеристику</h1>

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

    <div>
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

            <div class="form-group d-grid">
                <button type="submit" id="add_specification_button" class="btn btn-success">Добавить характеристику</button>
            </div>

        </form>
    </div>

@endsection

@section('custom-admin-js')
    <script>
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
    </script>
@endsection
