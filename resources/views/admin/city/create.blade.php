@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Add city')

@section('main-admin-content')
    <h1>Добавить город доставки</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('city.store') }}" method="POST" class="admin-create-items-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="country_id">Выберете страну</label>
            <select name="country_id" id="city_country_id" class="form-select">
                <option value="0" disabled selected>--- Выберете страну ---</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="region_id">Выберете регион</label>
            <select name="region_id" id="region_id" class="form-select">
                <option value="0" disabled selected>--- Выберете регион ---</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city_title">Город</label>
            <input type="text" name='title' placeholder="Введите название города" required class="form-control" id="city_title">
        </div>
        <div class="form-group">
            <button class="btn btn-success w-100" type="submit">Добавить город</button>
        </div>
    </form>

@endsection

@section('custom-admin-js')
<script>
    $('#city_country_id').change(function() {
        let country_sort_id = $('#city_country_id').val().trim();
        $.ajax({
            url: "{{ route('filter-country-for-city-create') }}",
            type: "POST",
            data: {
                country_sort_id: country_sort_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $('#region_id').empty();
                $('#region_id').append('<option value="0" disabled selected>--- Выберете регион доставки ---</option>');
                for (let i = 0; i < data.length; i++) {
                    let region_id = data[i]['id'];
                    let region_title = data[i]['title'];
                    $('#region_id').append('<option value="'+parseInt(region_id)+'">'+region_title+'</option>');
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
