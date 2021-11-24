<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Admin CSS -->
    <link rel="stylesheet" href="/css/admin/main-admin.css">
    <link rel="stylesheet" href="/css/admin/mobile-admin.css">
    <link rel="stylesheet" href="/css/admin/admin-products.css">
    <link rel="stylesheet" href="/css/admin/admin-side-filter.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/js/jquery.colorbox.js"></script>
    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/admin-script.js"></script>
    <title>Magazon | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <header class="admin__header">
        <div class="admin__header__logo">
            <a href="{{ route('home') }}"><img src="/img/logo.png" alt=""></a>
        </div>
        <div class="admin__header__links">
            <a href="{{ route('admin') }}">AdminPanel</a>
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Acasă</a>
        </div>
        <div class="admin__header__menu">
            <a data-bs-toggle="offcanvas" href="#admin_panel_menu" role="button" aria-controls="admin_panel_menu"><i class="fas fa-bars"></i></a>
        </div>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="admin_panel_menu" aria-labelledby="admin_panel_menu_label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="admin_panel_menu_label">AdminPanel | Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body">
            <div class="accordion" id="accordionExample">

                <!-- Разделы -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Secțiuni | Paзделы
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('chapter.index') }}">Toate secțiunile | Все разделы</a></li>
                                <li><a href="{{ route('chapter.create') }}">Adăugați secțiune | Добавить раздел</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Категории -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem2" aria-expanded="true" aria-controls="spoilerItem2">
                            Categorii | Категории
                        </button>
                    </h2>
                    <div id="spoilerItem2" class="accordion-collapse collapse" aria-labelledby="spoiler2" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('category.index') }}">Toate categoriile | Все категории</a></li>
                                <li><a href="{{ route('category.create') }}">Adăugați o categorie | Добавить категорию</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Подкатегории -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem3" aria-expanded="true" aria-controls="spoilerItem3">
                            Subcategorii | Подкатегории
                        </button>
                    </h2>
                    <div id="spoilerItem3" class="accordion-collapse collapse" aria-labelledby="spoiler3" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('subcategory.index') }}">Toate subcategoriile | Все подкатегории</a></li>
                                <li><a href="{{ route('subcategory.create') }}">Adăugați subcategorie | Добавить подкатегорию</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Товары -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem4" aria-expanded="true" aria-controls="spoilerItem4">
                            Bunuri | Товары @if ($new_product_admin_marker !== 0) <sup>New <b>{{$new_product_admin_marker}}</b></sup>@endif
                        </button>
                    </h2>
                    <div id="spoilerItem4" class="accordion-collapse collapse" aria-labelledby="spoiler4" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('product.index') }}">Toate mărfurile | Все товары</a>@if ($new_product_admin_marker !== 0) <sup>New <b>{{$new_product_admin_marker}}</b></sup>@endif</li>
                                <li><a href="{{ route('product.create') }}">Adăugați produs | Добавить товар</a></li>
                                <li><a href="{{ route('product.premoderate') }}">Moderare în așteptare | Ожидающие модерации</a>@if ($new_product_admin_marker !== 0) <sup><b>{{$new_product_admin_marker}}</b></sup>@endif</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Характеристики -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem5" aria-expanded="true" aria-controls="spoilerItem5">
                            Specificații | Характеристики
                        </button>
                    </h2>
                    <div id="spoilerItem5" class="accordion-collapse collapse" aria-labelledby="spoiler5" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('specification.index') }}">Toate caracteristicile | Все характеристики</a></li>
                                <li><a href="{{ route('specification.create') }}">Adăugați caracteristică | Добавить характеристику</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Пользователи -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem6" aria-expanded="true" aria-controls="spoilerItem6">
                            Membri | Пользователи
                        </button>
                    </h2>
                    <div id="spoilerItem6" class="accordion-collapse collapse" aria-labelledby="spoiler6" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('user.index') }}">Toți utilizatorii | Все пользователи</a></li>
                                <li><a href="{{ route('user.create') }}">Adăugați utilizator | Добавить пользователя</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Магазины -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler7">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem7" aria-expanded="true" aria-controls="spoilerItem7">
                            Magazinele | Магазины @if ($new_confirm_admin_marker !== 0) <sup>New <b>{{$new_confirm_admin_marker}}</b></sup>@endif
                        </button>
                    </h2>
                    <div id="spoilerItem7" class="accordion-collapse collapse" aria-labelledby="spoiler7" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('shop.index') }}">Все магазины</a></li>
                                <li><a href="{{ route('shop.create') }}">Добавить магазин</a></li>
                                <li><a href="{{ route('confirm.index') }}">Заявки на подтверждение</a>@if ($new_confirm_admin_marker !== 0) <sup><b>{{$new_confirm_admin_marker}}</b></sup>@endif</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Заказы -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler8">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem8" aria-expanded="true" aria-controls="spoilerItem8">
                            Comenzi | Заказы @if ($new_order_admin_marker !== 0) <sup>New <b>{{$new_order_admin_marker}}</b></sup>@endif
                        </button>
                    </h2>
                    <div id="spoilerItem8" class="accordion-collapse collapse" aria-labelledby="spoiler8" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('order.index') }}">Toate comenzile | Все заказы</a>@if ($new_order_admin_marker !== 0) <sup>New <b>{{$new_order_admin_marker}}</b></sup>@endif</li>
                                <li><a href="{{ route('order.index') }}">Noi comenzi | Новые заказы</a>@if ($new_order_admin_marker !== 0) <sup><b>{{$new_order_admin_marker}}</b></sup>@endif</li>
                                <li><a href="{{ route('order.create') }}">Adăugați comandă | Добавить заказ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Доставка -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler9">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem9" aria-expanded="true" aria-controls="spoilerItem9">
                            Livrare | Доставка
                        </button>
                    </h2>
                    <div id="spoilerItem9" class="accordion-collapse collapse" aria-labelledby="spoiler9" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="{{ route('country.index') }}">Țările de livrare | Страны доставки</a></li>
                                <li><a href="{{ route('country.create') }}">Adăugați țară | Добавить страну</a></li>
                                <hr>
                                <li><a href="{{ route('region.index') }}">Regiuni de livrare | Регионы доставки</a></li>
                                <li><a href="{{ route('region.create') }}">Adăugați o regiune | Добавить регион</a></li>
                                <hr>
                                <li><a href="{{ route('city.index') }}">Orașe de livrare | Города доставки</a></li>
                                <li><a href="{{ route('city.create') }}">Adăugați oraș | Добавить город</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Отзывы -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="spoiler10">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spoilerItem10" aria-expanded="true" aria-controls="spoilerItem10">
                            Recenzii | Отзывы
                        </button>
                    </h2>
                    <div id="spoilerItem10" class="accordion-collapse collapse" aria-labelledby="spoiler10" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <p>Recenzii de produse | Отзывы к товарам</p>
                                <li><a href="{{ route('rewiew.index') }}">Toate recenziile | Все отзывы</a></li>
                                <li><a href="{{ route('rewiew.create') }}">Adaugă o recenzie | Добавить отзыв</a></li>
                                <p>Recenzii la magazine | Отзывы к магазинам</p>
                                <li><a href="{{ route('shop-rewiew.index') }}">Toate recenziile | Все отзывы</a></li>
                                <li><a href="{{ route('shop-rewiew.create') }}">Adaugă o recenzie | Добавить отзыв</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

              </div>
        </div>
    </div>

    <div class="admin_panel__main_block">
        <div class="row" style="margin: 0;">
            <div class="col-lg-9 admin_panel__cental_content_block">
                @yield('main-admin-content')
            </div>
            <div class="col-lg-3 admin_panel__side_filter_block">
                @yield('admin-side-filter')
            </div>
        </div>
    </div>

    @yield('custom-admin-js')

</body>
</html>
