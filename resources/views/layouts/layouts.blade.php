<?php
    if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MagazON | @yield('title')</title>
        <link rel="shortcut icon" type="image/png" href="/img/logo-favicon.png">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        <!-- CSS -->
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/mobile.css">
        <!-- Fotorama CSS -->
        <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Fancybox CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- Fotorama JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
        <!-- Fancybox JS -->
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
        <!-- JS -->
        <script src="/js/cart-script.js"></script>
        <script src="/js/main.js"></script>
        
        <link href="/css/side-menu/side-menu.css" rel="stylesheet">
        <script src="/js/side-menu/side-menu.js"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>

        <header class="header-block-pc sticky-top">
            <div class="header-logo-container">
                <a class="header-logo-link" href="{{ route('home') }}"><img src="/img/logo.png" alt=""></a>
            </div>
            <div class="header-search-form-container">
                <form action="" method="post">
                    @csrf
                    <div class="search-form">
                        <input type="text" name="search-param" class="from-control" required id="header_search_form_input" list="header_search_form_input_list" placeholder="Search">
                        <datalist for="header_search_form_input" id="header_search_form_input_list">
                            @foreach ($products as $product)
                                <option value="{{ $product->title }}">{{ $product->title }}</option>
                            @endforeach
                        </datalist>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="header-category-button-container">
                <!-- <button class="header-category-button header-category-button-pc" type="button" data-bs-toggle="offcanvas" data-bs-target="#side_menu" aria-controls="side_menu"> -->
                <button class="header-category-button header-category-button-pc" id="side_menu_open_button" type="button" data-open-menu="side_menu">
                    <i class="fas fa-th-large"></i> Categorii
                </button>
            </div>
            <div class="header-contact-link-container">
                <a href="tel:+37322222222" class="header-phone-link-pc"><i class="fas fa-phone-alt"></i> 022-222-222</a>
            </div>
            <div class="header-cart-container">
                <a href="{{ route('cart') }}"><i class="fas fa-shopping-basket"></i>
                    <span class="cart_product_counter position-absolute top-0 start-100 translate-middle p-1 border border-light rounded-circle">
                        {{ isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotalQuantity() : '0' }}
                    </span>
                </a>
            </div>
            <div class="header-user-container">
                @if (Auth::user())
                    <a href="{{ route('cabinet') }}" title="Zona personală"><i class="fas fa-user"></i></a>
                    <a href="{{ route('logout') }}" title="Ieșire" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                @else
                    <a href="{{ route('login') }}" title="Intrare"><i class="fas fa-sign-in-alt"></i></a>
                @endif
            </div>
        </header>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>

        <header class="header-block-mobile sticky-top">

            <div class="mobile-header-top-section">
                <div class="mobile-header-logo-container">
                    <a class="header-logo-link" href="{{ route('home') }}"><img src="/img/logo.png" alt=""></a>
                </div>
                <div class="mobile-header-search-form-container">
                    <form action="" method="post">
                        @csrf
                        <div class="search-form">
                            <input type="text" name="search-param" class="from-control" required id="header_search_form_input" list="header_search_form_input_list" placeholder="Search">
                            <datalist for="header_search_form_input" id="header_search_form_input_list">
                                @foreach ($products as $product)
                                    <option value="{{ $product->title }}">{{ $product->title }}</option>
                                @endforeach
                            </datalist>
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="mobile-header-category-button-container">
                    <button class="header-category-button header-category-button-mobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile_side_menu" aria-controls="mobile_side_menu">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
            </div>

            <div class="mobile-header-bottom-section">
                <div class="mobile-header-contact-link-container">
                    <a href="tel:+37322222222" class="header-phone-link-pc"><i class="fas fa-phone-alt"></i></a>
                </div>
                <div class="mobile-header-cart-container">
                    <a href="{{ route('cart') }}"><i class="fas fa-shopping-basket"></i>
                        <span class="cart_product_counter position-absolute top-0 start-100 translate-middle p-1 border border-light rounded-circle">
                            {{ isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotalQuantity() : '0' }}
                        </span>
                    </a>
                </div>
                <div class="mobile-header-user-container">
                    @if (Auth::user())
                        <a href="{{ route('cabinet') }}" title="Zona personală"><i class="fas fa-user"></i></a>
                        <a href="{{ route('logout') }}" title="Ieșire" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                    @else
                        <a href="{{ route('login') }}" title="Intrare"><i class="fas fa-sign-in-alt"></i></a>
                    @endif
                </div>
            </div>

        </header>
        
        <!-- SIDE MENU 2 -->
        <div class="offside-menu" id="side_menu">
            <div class="side-menu-overlay"></div>
            <div class="offside-menu-flex-container">
                <div id="main_level_container">
                    <div class="main_level__header_container">
                        <p class="main_level__header">Categorii</p>
                        <button type="button" class="btn-close close-main-level-btn" aria-label="Închide" data-close-menu="side_menu"></button>
                    </div>
                    <div class="main_level_body">
                        @foreach ($chapters_for_menu as $chapter)
                        <button class="main_level_body__button" data-open-menu="chapter_{{$chapter->id}}_level_container">
                            {{ $chapter->title }}
                        </button>
                        @endforeach
                    </div>
                </div>
            
                @foreach($chapters_for_menu as $chapter)
                <div class="chapter_level_container" id="chapter_{{$chapter->id}}_level_container">
                    <div class="chapter_level__header_container">
                        <p class="chapter_level__header">{{$chapter->title}}</p>
                        <button type="button" class="btn-close close-chapter-level-btn" aria-label="Închide" data-close-menu="chapter_{{$chapter->id}}_level_container"></button>
                    </div>
                    <div class="chapter_level_body">
                        <a href="{{ route('show-chapter', $chapter->alias) }}" class="chapter_level_body__link">Toate produsele din secțiunea<br>"{{ $chapter->title}}"</a>
                        @foreach($chapter->categories as $category)
                        <button class="chapter_level_body__button" data-open-menu="category_{{$category->id}}_level_container">
                            {{ $category->title }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                @foreach($chapters_for_menu as $chapter)
                    @foreach($chapter->categories as $category)
                    <div class="category_level_container" id="category_{{$category->id}}_level_container">
                        <div class="category_level__header_container">
                            <p class="category_level__header">{{$category->title}}</p>
                            <button type="button" class="btn-close close-category-level-btn" aria-label="Închide" data-close-menu="category_{{$category->id}}_level_container"></button>
                        </div>
                        <div class="category_level_body">
                            <a href="{{ route('show-category', [$chapter->alias, $category->alias]) }}" class="chapter_level_body__link">Toate produsele din secțiunea<br>"{{ $category->title}}"</a>
                           @foreach ($category->sub_categories as $sub_category)
                                <a href="{{ route('show-sub_category', [$chapter->alias, $category->alias, $sub_category->alias]) }}" class="category_level_body__sub_category_link">{{ $sub_category->title}}</a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @endforeach
                
            </div>
        </div>
        <!-- SIDE MENU 2 -->
        
        <!-- OFFSIDE MENU -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobile_side_menu" aria-labelledby="side_menu_label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="side_menu_label">Categorii</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Închide"></button>
            </div>
            <div class="offcanvas-body">
                <div class="category-list-container">
                    @foreach ($chapters_for_menu as $chapter)
                    <a data-bs-toggle="collapse" href="#collapseChapter_{{ $chapter->id }}" role="button" aria-expanded="false" aria-controls="collapseChapter_{{ $chapter->id }}" class="chapter-menu-link">{{ $chapter->title }}</a>

                    <div class="collapse" id="collapseChapter_{{ $chapter->id }}">
                        <div class="collapse_chapters">
                            <a href="{{ route('show-chapter', $chapter->alias) }}" class="all-products-menu-link">Все товары в разделе "{{ $chapter->title}}"</a>
                            @foreach ($chapter->categories as $category)
                            <a data-bs-toggle="collapse" href="#collapseCategory_{{ $category->id }}" role="button" aria-expanded="false" aria-controls="collapseCategory_{{ $category->id }}" class="category-menu-link">{{ $category->title }}</a>

                            <div class="collapse" id="collapseCategory_{{ $category->id }}">
                                <div class="collapse_categories">
                                    <a href="{{ route('show-category', [$chapter->alias, $category->alias]) }}" class="all-products-sub-menu-link">Все товары в категории "{{ $category->title}}"</a>
                                    @foreach ($category->sub_categories as $sub_category)
                                    <a href="{{ route('show-sub_category', [$chapter->alias, $category->alias, $sub_category->alias]) }}" class="all-products-sub-menu-link">{{ $sub_category->title}}</a>
                                    @endforeach
                                </div>
                            </div>

                            @endforeach
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
          </div>
        <!-- END OFFSIDE MENU -->

        <div class="additional-block">
            @yield('additional-block')
        </div>

        <div class="auth-block">
            @yield('auth-block')
        </div>

        <main class="main-block-container">
            @yield('main-content-block')
        </main>

        <footer class="footer-block">
            <div class="footer-top-section">
                <div class="footer-logo-container">
                    <a href="{{route('home')}}"><img src="/img/logo.png" alt=""></a>
                </div>
                <div class="footer-info-container">
                    <p class="footer-info-container-header">Bloc informativ</p>
                    <ul class="footer-info">
                        <li><a href="" class="footer-info-link">Termeni de utilizare</a></li>
                        <li><a href="" class="footer-info-link">Notificare de confidențialitate</a></li>
                        <li><a href="" class="footer-info-link">Condiții de cooperare</a></li>
                        <li><a href="" class="footer-info-link">Link number 3</a></li>
                        <li><a href="" class="footer-info-link">Link number 4</a></li>
                    </ul>
                </div>
                <div class="footer-contacts-container">
                    <ul class="footer-contacts">
                        <li><a href="" class="footer-contacts-link footer-contacts-phone-link">022-222-222</a></li>
                        <li>
                            <a href="" class="footer-contacts-link footer-contacts-social-link"><i class="fab fa-instagram"></i></a>
                            <a href="" class="footer-contacts-link footer-contacts-social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="" class="footer-contacts-link footer-contacts-social-link"><i class="fab fa-telegram-plane"></i></a>
                            <a href="" class="footer-contacts-link footer-contacts-social-link"><i class="fab fa-whatsapp"></i></a>
                            <a href="" class="footer-contacts-link footer-contacts-social-link"><i class="fab fa-viber"></i></a>
                        </li>
                        <li><a href="" class="footer-contacts-link footer-contacts-mail-link">magazon@gmail.com</a></li>
                        <li><a href="" class="footer-contacts-link footer-contacts-map-link">Город, ул. Пушкина, оф.333</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom-section">
                <p class="footer-copyright">© 2021 magaz<b>ON</b> <span>Site elaborat de: <a href="https://moldstarter.md" target="_blank">mold<b>starter</b></a></span></p>
            </div>
        </footer>

        <script type="text/javascript">
            $(function() {

                $(window).scroll(function() {
                    if($(this).scrollTop() != 0) {
                        $('#toTop').fadeIn();
                    } else {
                        $('#toTop').fadeOut();
                    }
                });

                $('#toTop').click(function() {
                    $('body,html').animate({scrollTop:0},0);
                });

            });
        </script>

        <div id="toTop"><i class="fas fa-chevron-up"></i></div>

    @yield('custom_js')

    </body>
