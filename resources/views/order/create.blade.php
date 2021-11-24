@extends('layouts/layouts')

@section('title', 'Verifică')

@section('main-content-block')
<div class="order_page">
    @if(auth()->check())
        <h1 class="order_page__header">Verifică</h1>
        <div class="shop_page__breadcrumbs">
            <ul>
                <li class="shop_page__breadcrumbs__link"><a href="{{ route('home') }}">Acasă</a></li>
                <li class="shop_page__breadcrumbs__link_separator">/</li>
                <li class="shop_page__breadcrumbs__link"><a href="{{ route('cart') }}">Coş</a></li>
                <li class="shop_page__breadcrumbs__link_separator">/</li>
                <li class="shop_page__breadcrumbs__link active"><a>Verifică</a></li>
            </ul>
        </div>
        <div class="order_page__order_detail">
            @if (\Cart::session($_COOKIE['cart_id'])->isEmpty()==False )
                <div class="order_page__order_detail__total">
                    <p><b>Cost total:</b> {{ isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotal() : '0' }} MDL</p>
                    <p><b>Costul livrării:</b>@if (\Cart::session($_COOKIE['cart_id'])->getTotal() < 300) Este gratuit @else 50 MDL @endif</p>
                </div>
        </div>
        <div class="order_page__order_shipment_block">
            <h3>Informații despre livrare</h3>
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="order_last_name">Nume de familie</label>
                    <input type="text" name="last_name" id="order_last_name" class="form-control" required placeholder="Vă rugăm să introduceți numele de familie" value="{{ $user->last_name }}">
                </div>
                <div class="form-group">
                    <label for="order_name">Nume</label>
                    <input type="text" name="name" id="order_name" class="form-control" required placeholder="Introdu numele tau" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="order_email">E-mail</label>
                    <input type="email" name="email" id="order_email" class="form-control" required placeholder="Introduceți adresa dvs. de email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="order_phone">Телефон</label>
                    <input type="tel" name="phone" id="order_phone" class="form-control" required placeholder="Introdu numarul tau de telefon" value="{{ $user->phone_number }}">
                </div>

                <div class="form-group">
                    <label for="city_country_id">Țara de livrare</label>
                    <select name="country_ship" id="city_country_id" class="form-select">
                        @if (isset($user->shipment->country))
                            <option value=none disabled>--- Selectați țara de livrare ---</option>
                            @foreach ($countries as $country)
                            <option value={{ $country->id }} @if ($country->id == $user->shipment->country->id) selected @endif>{{ $country->title }}</option>
                            @endforeach
                        @else
                            <option value=none disabled selected>--- Selectați țara de livrare ---</option>
                            @foreach ($countries as $country)
                            <option value={{ $country->id }}>{{ $country->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="region_id">Regiunea de livrare</label>
                    <select name="region_ship" id="region_id" class="form-select">
                        @if (isset($user->shipment->region))
                            <option value=none disabled>--- Alegeți o regiune de livrare ---</option>
                            @foreach ($user->shipment->country->regions as $region)
                            <option value={{ $region->id }} @if ($region->id == $user->shipment->region->id) selected @endif >{{ $region->title }}</option>
                            @endforeach
                        @else
                            <option value=none disabled selected>--- Alegeți o regiune de livrare ---</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="city_id">Oraș de livrare</label>
                    <select name="city_ship" id="city_id" class="form-select">
                        @if (isset($user->shipment->city))
                            <option value=none disabled>--- Alegeți orașul de livrare ---</option>
                            @foreach ($user->shipment->region->cities as $city)
                            <option value={{ $city->id }} @if ($city->id == $user->shipment->city->id) selected @endif >{{ $city->title }}</option>
                            @endforeach
                        @else
                            <option value=none disabled selected>--- Alegeți orașul de livrare ---</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="full_adress">Stradă, casă, apartament</label>
                    <input type="text" name="full_adress" id="full_adress" class="form-control" required placeholder="De exemplu: st. Pușkin 33/133" @if (isset($user->shipment->full_adress))value="{{ $user->shipment->full_adress }}"@endif>
                </div>

                <div class="form-group d-grid">
                    <button type="submit">Verifică</button>
                </div>
            </form>
        </div>
        @else
            <div class="order_page__empty_cart">
                <h2 class="order_page__order_detail__empty_cart">Coșul dvs. este gol.</h2>
                <a class="order_page__order_detail__empty_cart__link" href="{{ route('catalog') }}">Înapoi la cumpărături</a>
            </div>
        @endif
    @else
        <p class="order_page__not_login">Pentru a plasa o comandă trebuie să vă <a href="{{ route('login') }}">autentificați</a> sau <a href="{{ route('register') }}">să vă înregistrați</a></p>
    @endif
</div>

@endsection

@section('custom_js')
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
                    $('#region_id').append('<option value="0" disabled selected>--- Alegeți o regiune de livrare ---</option>');
                    $('#city_id').empty();
                    $('#city_id').append('<option value="0" disabled selected>--- Alegeți orașul de livrare ---</option>');
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

        $('#region_id').change(function() {
            let region_sort_id = $('#region_id').val().trim();
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
                    $('#city_id').empty();
                    $('#city_id').append('<option value="0" disabled selected>--- Alegeți orașul de livrare ---</option>');
                    for (let i = 0; i < data.length; i++) {
                        let city_id = data[i]['id'];
                        let city_title = data[i]['title'];
                        $('#city_id').append('<option value="'+parseInt(city_id)+'">'+city_title+'</option>');
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
