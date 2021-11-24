@extends('layouts/layouts')

@section('title')
"{{ $shop->title }}" | Все отзывы
@endsection

@section('main-content-block')

<h1 class="shop_page__header">Все отзывы</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('statistic-shop', $shop->id) }}">Статистика</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Все отзывы</a></li>
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

@if (null == $all_reviews)
<div>
    <h2 class="shop_page__empty_header">К сожалению для <a href="{{ route('seller') }}">Вашего магазина</a> и <a href="{{ route('all-shop-products', $shop->id) }}">и товаров</a> еще нет отзывов.</h2>
</div>
@else

<div class="shop_page__all_reviews_container">

    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="shop_page__review_btn active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Отзывы к магазину <b>{{ $shop->reviews->count() }}</b></button>
            <button class="shop_page__review_btn" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Отзывы к товарам <b>{{ $count_product_reviews }}</b></button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
              @if ($shop->reviews->count() == 0)
              <h4 class="shop_page__empty_header">Для <a href="{{ route('seller') }}">Вашего магазина</a> пока нет отзывов.</h4>
              @else
              <table class="shop_page__all_reviews__reviews_items">
                <tr class="shop_page__all_reviews__reviews_items__headers">
                    <th class="shop_page__all_reviews__reviews__review_th">Отзыв</th>
                    <th class="shop_page__all_reviews__reviews__rating_th">Оценка</th>
                    <th class="shop_page__all_reviews__reviews__user_th">Пользователь</th>
                    <th class="shop_page__all_reviews__reviews__date_th">Дата добавления отзыва</th>
                </tr>
                @foreach ($shop->reviews as $review)
                <tr>
                    <td class="shop_page__all_reviews__reviews__review_td">{{ $review->review }}</td>
                    <td class="shop_page__all_reviews__reviews__rating_td">{{ $review->rating }}</td>
                    <td class="shop_page__all_reviews__reviews__user_td"><a href="mailto:{{ $review->user->email }}">{{ $review->user->email }}</a></td>
                    <td class="shop_page__all_reviews__reviews__date_td">{{ $review->updated_at }}</td>
                </tr>
                @endforeach
            </table>
              @endif
          </div>
          <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <div class="shop_page__all_reviews">

                @if ( count($all_reviews['product_reviews']) == 0)
                <h4 class="shop_page__empty_header">Для <a href="{{ route('all-shop-products', $shop->id) }}">товаров</a> в Вашем магазине пока нет отзывов.</h4>
                @else
                @foreach ($products as $product)
                    @if ($product->rewiews->isNotEmpty())
                    <button class="shop_page__review__collapse_btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_product_{{$product->id}}" aria-expanded="false" aria-controls="collapse_product_{{$product->id}}">
                    Отзывы к товару "{{ $product->title }}"
                    </button>
                    <div class="collapse shop_page__review_collapse" id="collapse_product_{{$product->id}}">
                        <table class="shop_page__all_reviews__reviews_items">
                            <tr class="shop_page__all_reviews__reviews_items__headers">
                                <th class="shop_page__all_reviews__reviews__product__review_th">Отзыв</th>
                                <th class="shop_page__all_reviews__reviews__product__rating_th">Оценка</th>
                                <th class="shop_page__all_reviews__reviews__product__user_th">Пользователь</th>
                            </tr>
                            @foreach ($product->rewiews as $review)
                            <tr class="shop_page__all_reviews__reviews_items__review_separator">
                                <td class="shop_page__all_reviews__reviews__product__review_td">{{ $review->rewiew}}</td>
                                <td class="shop_page__all_reviews__reviews__product__rating_td">{{ $review->rating }}</td>
                                <td class="shop_page__all_reviews__reviews__product__user_td"><a href="mailto:{{ $review->user->email }}">{{ $review->user->email }}</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                @endforeach
                @endif
            </div>

          </div>
        </div>
      </div>

</div>
@endif
@endsection
