@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Edit order #{{ $order->id }}
@endsection

@section('main-admin-content')
    <script>
        function removeProduct(product_id) {
            var order_id = {{ $order->id }};
            var removeProduct = true;
            $.ajax({
                url: "{{ route('order.store', $order->id) }}",
                type: "POST",
                data: {
                    product_id: product_id, order_id: order_id, removeProduct: removeProduct
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                },
                success: (data) => {
                    location.reload();
                },
                dataType: "json",
                error: (data) => {
                    console.log(data);
                }
            });
        }
    </script>

    <h1>Изменить заказ #{{ $order->id }}</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

<div>
    <form action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="order_status">Статус заказа</label>
            <select name="status" id="order_status" class="form-select">
                <option value=0 @if ($order->status == 0) selected @endif>Оформлен</option>
                <option value=1 @if ($order->status == 1) selected @endif>Подтвержден</option>
                <option value=2 @if ($order->status == 2) selected @endif>Выполнен</option>
                <option value=3 @if ($order->status == 3) selected @endif>Отменен</option>
            </select>
        </div>
        <div class="form-group">
            <p>Продукты в заказе:</p>
            @foreach ($order->products->unique() as $product)
            <p>
                ID: <b>{{ $product->id }}</b> |
                <a href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a> |
                Количество: <input type="number" class="order_product_qty" data-product_id={{ $product->id }} required value={{$order->products->countBy('id')[$product->id]}} min=0 max=10>
                <button type="button" onclick="removeProduct({{ $product->id }})"><i class="far fa-trash-alt"></i></button>
            </p>
            @endforeach
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_product_in_order">Добавить товар в заказ</button>
        </div>
        <div class="form-group">
            <label for="order_last_name">Фамилия</label>
            <input type="text" class="form-control" id="order_last_name" name="last_name" required placeholder="Введите фамилию" value="{{ $order->last_name }}">
        </div>
        <div class="form-group">
            <label for="order_name">Имя</label>
            <input type="text" class="form-control" id="order_name" name="name" required placeholder="Введите имя" value="{{ $order->name }}">
        </div>
        <div class="form-group">
            <label for="order_email">Email</label>
            <input type="email" class="form-control" id="order_email" name="email" required placeholder="Введите email" value="{{ $order->email }}">
        </div>
        <div class="form-group">
            <label for="order_phone">Телефон</label>
            <input type="tel" class="form-control" id="order_phone" name="phone" required placeholder="Введите номер телефона" value="{{ $order->phone }}">
        </div>
        <div class="form-group">
            <label for="order_country">Страна доставки</label>
            <select name="country_id" id="order_country" class="form-select">
                <option value=0 disabled>--- Выберете страну доставки ---</option>
                @foreach ($countries as $country)
                    <option value={{ $country->id }} @if ($country->id == $order->country->id) selected @endif>{{ $country->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="order_region">Регион доставки</label>
            <select name="region_id" id="order_region" class="form-select">
                <option value=0 disabled>--- Выберете регион доставки ---</option>
                @foreach ($order->country->regions as $region)
                    <option value={{ $region->id }} @if ($region->id == $order->region->id) selected @endif>{{ $region->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="order_city">Город доставки</label>
            <select name="city_id" id="order_city" class="form-select">
                <option value=0 disabled>--- Выберете город доставки ---</option>
                @foreach ($order->region->cities as $city)
                    <option value={{ $city->id }} @if ($city->id == $order->city->id) selected @endif>{{ $city->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="order_adress">Адрес доставки</label>
            <input type="text" class="form-control" id="order_adress" name="adress_shipment" required placeholder="Введите адрес доставки" value="{{ $order->adress_shipment }}">
        </div>
        <div class="form-group d-grid">
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
        </div>
    </form>
</div>

<!-- Форма добавления товара к заказу -->
    <div class="modal fade" id="add_product_in_order" tabindex="-1" aria-labelledby="add_product_in_order_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_product_in_order_label">Добавить товар к заказу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('order.store', $order->id) }}" method="POST" id="add_product_in_order_form">
                        @csrf
                        <input type="number" value="1" required readonly hidden name="add_product_in_order_marker">
                        <div class="form-group">
                            <label for="order_product_id">Товар</label>
                            <select name="order_product_id" id="order_product_id" class="form-select">
                                <option value=0 disabled selected>--- Выберете товар ---</option>
                                @foreach ($products as $product)
                                <option value={{ $product->id }}>{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order_product_qty">Количество товара</label>
                            <input type="number" name="order_product_qty" id="order_product_qty" class="form-control" value="1" step="1" min="1" max="999">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-success" form="add_product_in_order_form" id="add_product_in_order_form_button">Добавить товар</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-admin-js')
    <script>
        $(document).ready(function() {

            $('#add_product_in_order_form_button').click(function() {
                var order_id = parseInt({{ $order->id }});
                var add_product_in_order_marker = true;
                var order_product_id = parseInt($('#order_product_id').val());
                var order_product_qty = parseInt($('#order_product_qty').val());

                $.ajax({
                    url: "{{ route('order.store', $order->id) }}",
                    type: "POST",
                    data: {
                        add_product_in_order_marker: add_product_in_order_marker, order_product_id: order_product_id, order_product_qty: order_product_qty, order_id: order_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        location.reload();
                    },
                    dataType: "json",
                    error: (data) => {
                        console.log(data);
                    }
                });
            });

            $('.order_product_qty').change(function() {
                var product_id = parseInt($(this).data("product_id"));
                var product_qty = $(this).val();
                var order_id = {{ $order->id }};

                $.ajax({
                    url: "{{ route('order.store', $order->id) }}",
                    type: "POST",
                    data: {
                        product_id: product_id, product_qty: product_qty, order_id: order_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        location.reload();
                    },
                    dataType: "json",
                    error: (data) => {
                        console.log(data);
                    }
                });
            });

        });

        $('#order_country').change(function() {
            let country_sort_id = $('#order_country').val().trim();
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
                    $('#order_region').empty();
                    $('#order_region').append('<option value="0" disabled selected>--- Выберете регион ---</option>');
                    $('#order_city').empty();
                    $('#order_city').append('<option value="0" disabled selected>--- Выберете город ---</option>');
                    for (let i = 0; i < data.length; i++) {
                        let region_id = data[i]['id'];
                        let region_title = data[i]['title'];
                        $('#order_region').append('<option value="'+parseInt(region_id)+'">'+region_title+'</option>');
                    }
                },
                dataType: "json",
                error: (data) => {
                    console.log(data);
                }
            });
        });

        $('#order_region').change(function() {
            let region_sort_id = $('#order_region').val().trim();
            $.ajax({
                url: "{{ route('filter-region-for-city-create') }}",
                type: "POST",
                data: {
                    region_sort_id: region_sort_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                },
                success: (data) => {
                    $('#order_city').empty();
                    $('#order_city').append('<option value="0" disabled selected>--- Выберете город ---</option>');
                    for (let i = 0; i < data.length; i++) {
                        let city_id = data[i]['id'];
                        let city_title = data[i]['title'];
                        $('#order_city').append('<option value="'+parseInt(city_id)+'">'+city_title+'</option>');
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
