@extends('layouts/layouts')

@section('title')
"{{ $shop->title }}" | "{{ $product->title }}" | Все товары
@endsection

@section('main-content-block')

<h1 class="shop_page__header">Все отзывы</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('all-shop-products', $shop->id) }}">Все товары</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Отзывы к товару "{{ $product->title }}"</a></li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (isset($errors))
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
        <strong>{{ $error }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach
@endif

<div class="shop_page__all_reviews__statistic">
    <p>Товар: <b>{{ $product->title }}</b>, @if ($all_reviews_count !==0 )всего отзывов: <b>{{ $all_reviews_count }}</b>, средняя оценка: <b>{{ $all_reviews_rating }}</b>,@endif всего просмотров товара: <b>@if ( null == $product->view_count )0 @else {{ $product->view_count }}@endif</b></p>
</div>
@if ($reviews->isEmpty())
<div>
    <h2 class="shop_page__empty_header">К сожалению для товара <a href="{{ route('edit-shop-product', [$shop->id, $product->id]) }}">{{ $product->title }}</a> еще нет отзывов.</h2>
</div>
@else
<div class="shop_page__all_reviews">
    <table class="shop_page__all_reviews__items">
        <tr class="shop_page__all_reviews__items__headers">
            <th class="shop_page__all_reviews__item__review">Отзыв</th>
            <th class="shop_page__all_reviews__item__rating">Оценка</th>
            <th class="shop_page__all_reviews__item__user">Пользователь</th>
        </tr>
        @foreach ($reviews as $review)
        <tr>
            <td class="shop_page__all_reviews__item__review_review">{{ $review->rewiew }}</td>
            <td class="shop_page__all_reviews__item__rating_review">{{ $review->rating }}</td>
            <td class="shop_page__all_reviews__item__user_review"><a href="mailto:{{ $review->user->email }}">{{ $review->user->email }}</a></td>
        </tr>
        @endforeach
    </table>
</div>

<div class="shop_page__paginate">
{{ $reviews->links('pagination.paginate') }}
</div>
@endif
@endsection
