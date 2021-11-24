@extends('layouts/layouts')

@section('title', 'Home')

@section('main-content-block')

<div id="main_page_carosel__sales" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="4" aria-label="Slide 5"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="5" aria-label="Slide 6"></button>
        <button type="button" data-bs-target="#main_page_carosel__sales" data-bs-slide-to="6" aria-label="Slide 7"></button>
    </div>
    <div class="carousel-inner active main_page_carosel__sales__carousel_inner">
        <div class="carousel-item active main_page_carosel__sales__image_container">
            <img src="/img/slide-1.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-2.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-3.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-4.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-5.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-6.jpg" class="d-block w-100" alt="">
        </div>
        <div class="carousel-item main_page_carosel__sales__image_container">
            <img src="/img/slide-7.jpg" class="d-block w-100" alt="">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#main_page_carosel__sales"  data-bs-slide="prev">
        <span class="carousel-control-prev-icon main_page_carosel__sales__prev_icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#main_page_carosel__sales"  data-bs-slide="next">
        <span class="carousel-control-next-icon main_page_carosel__sales__next_icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
    </button>
</div>
<!-- Sales products -->
@if ($sales_products->isNotEmpty())
@include('products_card.sales_products')
@endif
<!-- Sales products -->

<!-- Popular products -->
@if ($popular_products->isNotEmpty())
@include('products_card.popular_products')
@endif
<!-- Popular products -->

<!-- Recommended products -->
@if ($recommend_products->isNotEmpty())
@include('products_card.recommend_products')
@endif
<!-- Recommended products -->

<!-- Recently products -->
@if ($recently_products!==null)
@if ($recently_products->isNotEmpty())
@include('products_card.recently_products')
@endif
@endif
<!-- Recently products -->


@endsection
