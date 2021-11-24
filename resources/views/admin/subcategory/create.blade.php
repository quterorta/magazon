@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add subcategory')

@section('main-admin-content')
    <h1>Добавить подкатегорию</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('subcategory.store') }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="chapter_title">Выберете раздел</label>
            <select name="chapter_id" id="category_chapter_id" class="form-select">
                <option value="0" disabled selected>--- Выберете раздел ---</option>
                @foreach ($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory_category_id">Выберете категорию</label>
            <select name="category_id" id="subcategory_category_id" class="form-select">
                <option value="0" disabled selected>--- Выберете категорию ---</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory_title">Название подкатегории</label>
            <input type="text" name='title' placeholder="Введите название подкатегории" required class="form-control" id="subcategory_title">
        </div>
        <div class="form-group">
            <label for="subcategory_image">Изображение для подкатегории</label>
            <input type="file" name='image' placeholder="Выберете изображение для подкатегории" required class="form-control" id="subcategory_image">
        </div>

        <div class="form-group">
            <label for="subcategory_alias">Slug подкатегории (ЧПУ)</label>
            <input type="text" name='alias' placeholder="Slug подкатегории" required class="form-control" id="subcategory_alias">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Добавить подкатегорию</button>
        </div>
    </form>

@endsection

@section('custom-admin-js')
<script>
    $('#category_chapter_id').change(function() {
        let chapter_sort_id = $('#category_chapter_id').val().trim();
        $.ajax({
            url: "{{ route('filter-category-for-subcategory-create') }}",
            type: "POST",
            data: {
                chapter_sort_id: chapter_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#subcategory_category_id').empty();
                $('#subcategory_category_id').append('<option value="0" disabled selected>--- Выберете категорию ---</option>');
                for (let i = 0; i < data.length; i++) {
                    let category_id = data[i]['id'];
                    let category_title = data[i]['title'];
                    $('#subcategory_category_id').append('<option value="'+parseInt(category_id)+'">'+category_title+'</option>');
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
