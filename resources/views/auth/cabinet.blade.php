@extends('layouts/layouts')

@section('title', 'Cabinet')

@section('main-content-block')

@if (Auth::user())
  <p class="cabinet_page__main_header">Buna ziua, <b>{{ $user->name }}</b></p>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

  <div class="d-flex align-items-start">
    <div class="nav flex-column nav-pills cabinet_page__nav_pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <button class="nav-link active" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button" role="tab" aria-controls="settings-tab" aria-selected="true">Setarile profilului</button>
      <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab" aria-controls="orders-tab" aria-selected="false">Comenzi</button>
      <a class="nav-link" href="{{ route('favorite-products', $user->id) }}">Favorite</a>
      @if ($user->roles->first()->name == 'seller')
      <a class="nav-link" href="{{ route('seller') }}">Magazinul meu</a>
      @endif
      <button class="nav-link" id="adress-tab" data-bs-toggle="pill" data-bs-target="#adres" type="button" role="tab" aria-controls="adress-tab" aria-selected="false">Adresă de livrare</button>
      @if ($user->roles->first()->name == 'admin')
      <a class="nav-link" href="{{ route('admin') }}">AdminPanel</a>
      @endif
      <a class="nav-link nav-link-logout" type="button" role="tab" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Ieși</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
    </div>

    <div class="tab-content" id="v-pills-tabContent">

      <div class="tab-pane fade show active cabinet_page__tab__settings_tab" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <p class="cabinet_page__tab__tab_header">Setarile profilului</p>
        <p class="cabinet_page__tab__tab_subheader">Date personale</p>
        <form action="{{ route('user-info-update') }}" method="POST" class="">
            @csrf
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="user_last_name_field">Nume de familie</label>
                <input type="text" name="last_name" placeholder="Vă rugăm să introduceți numele de familie" class="form-control" required id="user_last_name_field" @if (isset($user->last_name)) value="{{ $user->last_name }}" @endif>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="user_name_field">Nume</label>
                <input type="text" name="name" placeholder="Introdu numele tau" class="form-control" required id="user_name_field" @if (isset($user->name)) value="{{ $user->name }}" @endif>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="user_email_field">E-mail</label>
                <input type="text" name="email" placeholder="Introduceți adresa dvs. de email" class="form-control" required id="user_email_field" @if (isset($user->email)) value="{{ $user->email }}" @endif>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="user_phone_field">Telefon</label>
                <input type="tel" name="phone_number" placeholder="Introdu numarul tau" class="form-control" required id="user_phone_field" @if (isset($user->phone_number)) value="{{ $user->phone_number }}" @endif>
              </div>
            </div>
          </div>

          <div class="form-group d-grid mt-3">
            <button type="submit" class="btn btn-success">Salvează modificările</button>
          </div>

        </form>
      </div>

      <div class="tab-pane fade cabinet_page__tab__orders_tab" id="orders" role="tabpanel" aria-labelledby="orders-tab">
        <p class="cabinet_page__tab__tab_header">Comenzile tale</p>
        @if ($user->orders->isNotEmpty())

        <div class="cabinet_page__orders_block">
            <div class="cabinet_page__orders_block__grid_row cabinet_page__orders_block__grid_header_row">
                <div class="cabinet_page__orders_block__grid_row__id_header">ID</div>
                <div class="cabinet_page__orders_block__grid_row__status_header">Stărea</div>
                <div class="cabinet_page__orders_block__grid_row__products_header">Bunuri</div>
                <div class="cabinet_page__orders_block__grid_row__shipment_header">Date de livrare</div>
                <div class="cabinet_page__orders_block__grid_row__date_header">Data comandă</div>
            </div>
            @foreach ($user->orders as $order)
            <div class="cabinet_page__orders_block__grid_row cabinet_page__orders_block__grid_item_row">
                <div class="cabinet_page__orders_block__grid_row__id">
                    <p>{{ $order->id }}</p>
                </div>
                <div class="cabinet_page__orders_block__grid_row__status">
                    @if ($order->status == 0)
                    <p>Verificat <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true" title="Verificat - Comanda a fost adăugată la baza de date și așteaptă confirmarea. Confirmat - Comanda a fost verificată, managerul v-a sunat și a clarificat toate detaliile comenzii. Finalizat - Produsul a fost achitat și livrat."></i></p>
                    @elseif($order->status == 1)
                    <p>Confirmat <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true" title="Verificat - Comanda a fost adăugată la baza de date și așteaptă confirmarea. Confirmat - Comanda a fost verificată, managerul v-a sunat și a clarificat toate detaliile comenzii. Finalizat - Produsul a fost achitat și livrat."></i></p>
                    @elseif($order->status == 2)
                    <p>Finalizat <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true" title="Verificat - Comanda a fost adăugată la baza de date și așteaptă confirmarea. Confirmat - Comanda a fost verificată, managerul v-a sunat și a clarificat toate detaliile comenzii. Finalizat - Produsul a fost achitat și livrat."></i></p>
                    @endif
                </div>
                <div class="cabinet_page__orders_block__grid_row__products">
                    @foreach ($order->products->unique() as $product)
                    <p><a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}">{{ $product->title }}</a> <b>x {{ $order->products->countBy('id')[$product->id] }}</b></p>
                    @endforeach
                </div>
                <div class="cabinet_page__orders_block__grid_row__shipment">
                    <p class="cabinet_page__orders_block__grid_row__shipment__order_name">{{ $order->name }}</p>
                    <p class="cabinet_page__orders_block__grid_row__shipment__order_phone">{{ $order->phone }}</p>
                    <p class="cabinet_page__orders_block__grid_row__shipment__order_adres">{{ $order->country->title }}, {{ $order->region->title }}, {{ $order->city->title }}, {{ $order->adress_shipment }}</p>
                </div>
                <div class="cabinet_page__orders_block__grid_row__date">
                    <p class="cabinet_page__orders_block__grid_row__shipment__order_date">{{ $order->created_at->format('d/m/Y') }}</p>
                    <p class="cabinet_page__orders_block__grid_row__shipment__order_time">{{ $order->created_at->toTimeString() }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <p class="cabinet_page__empty_orders_block">
                Din păcate, nu aveți încă comenzi :(<br>
                <a href="{{ route('catalog') }}">Mergi la cumpărături</a>
            </p>
        @endif
      </div>

      <div class="tab-pane fade cabinet_page__tab__adres_tab" id="adres" role="tabpanel" aria-labelledby="adress-tab">
        <p class="cabinet_page__tab__tab_header">Adresă de livrare</p>
        <p class="cabinet_page__tab__tab_subheader">Va fi utilizat implicit în timpul comenzii (îl puteți schimba oricând)</p>
        @if (isset(Auth::user()->shipment))
        <form action="{{ route('shipment-update') }}" method="POST" class="">
            @csrf
            <div class="form-group">
                <label for="city_country_id">Țară</label>
                <select name="country_ship" id="city_country_id" class="form-select">
                    <option value="0" disabled>--- Alege-ți țara ---</option>
                    @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @if ($country->id == $user_country->id) selected @endif>{{ $country->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="region_id">Regiune</label>
                <select name="region_ship" id="region_id" class="form-select">
                    <option value="0" disabled>--- Selectați regiunea ---</option>
                    @foreach ($user_country->regions as $region)
                    <option value="{{ $region->id }}" @if ($region->id == $user_region->id) selected @endif >{{ $region->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="city_id">Oraș</label>
                <select name="city_ship" id="city_id" class="form-select">
                    <option value="0" disabled>--- Alegeți un oraș ---</option>
                    @foreach ($user_region->cities as $city)
                    <option value="{{ $city->id }}" @if ($city->id == $user_city->id) selected @endif >{{ $city->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="full_adress">Stradă, casă, apartament</label>
                <input type="text" name="full_adress" id="full_adress" class="form-control" required placeholder="De exemplu: st. Pușkin 33/133" value="{{ Auth::user()->shipment->full_adress }}">
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="btn btn-success mt-3">Salvează modificările</button>
            </div>

        </form>
        @else
        <form action="{{ route('shipment-create') }}" method="POST" class="">
            @csrf
            <div class="form-group">
                <label for="city_country_id">Țară</label>
                <select name="country_ship" id="city_country_id" class="form-select">
                    <option value="0" selected disabled>--- Alege-ți țara ---</option>
                    @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="region_id">Regiune</label>
                <select name="region_ship" id="region_id" class="form-select">
                    <option value="0" disabled selected>--- Selectați regiunea ---</option>
                </select>
            </div>

            <div class="form-group">
                <label for="city_id">Oraș</label>
                <select name="city_ship" id="city_id" class="form-select">
                    <option value="0" disabled selected>--- Alegeți un oraș ---</option>
                </select>
            </div>

            <div class="form-group">
                <label for="full_adress">Stradă, casă, apartament</label>
                <input type="text" name="full_adress" id="full_adress" class="form-control" required placeholder="De exemplu: st. Pușkin 33/133">
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="btn btn-success mt-3">Salvați adresa de expediere</button>
            </div>

        </form>
        @endif
      </div>
    </div>
  </div>

@else
    <p class="cabinet_page__not_login_user">Pentru a accesa contul dvs. personal, trebuie să vă <a href="{{ route('login') }}">introduceți</a> sau <a href="{{ route('register') }}">să vă înregistrați</a>.</p>
@endif

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
                $('#region_id').append('<option value="0" disabled selected>--- Выберете регион ---</option>');
                $('#city_id').empty();
                $('#city_id').append('<option value="0" disabled selected>--- Выберете город ---</option>');
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
                $('#city_id').append('<option value="0" disabled selected>--- Выберете город ---</option>');
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

@endsection
