@extends('layouts/layouts')

@section('title')
"{{ $shop->title }}" | Все товары
@endsection

@section('main-content-block')

<h1 class="shop_page__header">Все товары</h1>

<div class="shop_page__breadcrumbs">
    <ul>
        <li class="shop_page__breadcrumbs__link"><a href="{{ route('seller') }}">Магазин</a></li>
        <li class="shop_page__breadcrumbs__link_separator">/</li>
        <li class="shop_page__breadcrumbs__link active"><a>Все товары</a></li>
    </ul>
</div>
<div class="shop_page__control_btns">
    <a href="{{ route('create-shop-product', $shop->id) }}" class="shop_page__all_products__control_links">Добавить товар</a>
    <div class="dropdown">
        <a href="#" role="button" id="sortMenuLinks" data-bs-toggle="dropdown" aria-expanded="false" class="shop_page__all_products__control_links">@if (isset($sort_type)) Сортировка: {{ $sort_type }} @else Сортировка товаров @endif</a>
        <ul class="dropdown-menu shop_page__dropdown_menu" aria-labelledby="sortMenuLinks">
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-new") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-new"]) }}">Сначала более новые</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-old") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-old"]) }}">Сначала более старые</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-az") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-az"]) }}">По алфавиту (А-Я)</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-za") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-za"]) }}">По алфавиту (Я-А)</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-popular") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-popular"]) }}">Сначала более популярные</a></li>
            <li><a class="dropdown-item shop_page__dropdown_menu__item @if(isset($sort_by) and $sort_by=="by-notpopular") shop_page__dropdown_menu__active_item @endif" href="{{ route('sort-all-shop-products', [$shop->id, "by-notpopular"]) }}">Сначала менее популярные</a></li>
        </ul>
    </div>

    <a href="#" role="button" id="filterMenuForm" data-bs-toggle="modal" class="shop_page__all_products__control_links" data-bs-target="#shop_page__modal">Фильтр товаров</a>

    <div class="modal fade" id="shop_page__modal" tabindex="-1" aria-labelledby="shop_page__modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shop_page__modal_label">Фильтр товаров</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="shop_page__modal__filter_form" id="shop_page__modal__modal_form__filter_form" name="myForm" method="GET">
                        <div class="shop_page__dropdown_menu__collapse_block">
                            <button class="shop_page__dropdown_menu__collapse_button" type="button" data-bs-toggle="collapse" data-bs-target="#category_select" aria-expanded="false" aria-controls="category_select">
                                Категория
                            </button>
                            <div class="collapse" id="category_select">
                                @foreach ($filter_categories as $category)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="check_category_{{ $category->id }}" value={{ $category->id }} name="category_id[]" @if ( null !== Request::input('category_id') and in_array($category->id, Request::input('category_id'))) checked @endif>
                                    <label class="form-check-label" for="check_category_{{ $category->id }}">{{ $category->title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="shop_page__dropdown_menu__collapse_block">
                            <button class="shop_page__dropdown_menu__collapse_button" type="button" data-bs-toggle="collapse" data-bs-target="#sub_category_select" aria-expanded="false" aria-controls="sub_category_select">
                                Подкатегория
                            </button>
                            <div class="collapse" id="sub_category_select">
                                @foreach ($filter_sub_categories as $sub_category)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="check_sub_category_{{ $sub_category->id }}" value={{ $sub_category->id }} name="sub_category_id[]" @if ( null !== Request::input('sub_category_id') and in_array($sub_category->id, Request::input('sub_category_id'))) checked @endif>
                                    <label class="form-check-label" for="check_sub_category_{{ $sub_category->id }}">{{ $sub_category->title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="shop_page__dropdown_menu__collapse_block">
                            <button class="shop_page__dropdown_menu__collapse_button" type="button" data-bs-toggle="collapse" data-bs-target="#moderate_select" aria-expanded="false" aria-controls="moderate_select">
                                Товары прошли модерацию
                            </button>
                            <div class="collapse" id="moderate_select">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="check_moderate_0" value=0 name="moderate" @if ( null !== Request::input('moderate') and 0 == Request::input('moderate')) checked @endif>
                                    <label class="form-check-label" for="check_moderate_0">Нет</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="check_moderate_1" value=1 name="moderate" @if ( null !== Request::input('moderate') and 1 == Request::input('moderate')) checked @endif>
                                    <label class="form-check-label" for="check_moderate_1">Да</label>
                                </div>
                            </div>
                        </div>
                        <div class="shop_page__dropdown_menu__collapse_block">
                            <button class="shop_page__dropdown_menu__collapse_button" type="button" data-bs-toggle="collapse" data-bs-target="#active_select" aria-expanded="false" aria-controls="active_select">
                                Товары в наличии
                            </button>
                            <div class="collapse" id="active_select">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="check_active_0" value=0 name="active" @if ( null !== Request::input('active') and 0 == Request::input('active')) checked @endif>
                                    <label class="form-check-label" for="check_active_0">Нет</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="check_active_1" value=1 name="active" @if ( null !== Request::input('active') and 1 == Request::input('active')) checked @endif>
                                    <label class="form-check-label" for="check_active_1">Да</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn shop_page__dropdown_menu__filter_btn" form="shop_page__modal__modal_form__filter_form">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
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

@if ($products->isEmpty())
<h2 class="shop_page__empty_header">Пока нет товаров. <a href="{{ route('create-shop-product', $shop->id) }}">Добавьте новый товар!</a></h2>
@else
<div class="shop_page__all_products">
    <table class="shop_page__all_products__items">
        <tr class="shop_page__all_products__items__headers">
            <th class="shop_page__all_products__item__id">ID</th>
            <th class="shop_page__all_products__item__title">Название</th>
            <th class="shop_page__all_products__item__view">Просмотров</th>
            <th class="shop_page__all_products__item__active">В наличии</th>
            <th class="shop_page__all_products__item__moderate">Прошел модерацию</th>
            <th class="shop_page__all_products__item__controll">Управление</th>
        </tr>
        @foreach ($products as $product)
        <tr @if ($product->moderate == 1) class="product_item__moderate_item" @else class="product_item__none_moderate_item" @endif>
            <td class="shop_page__all_products__item__id_product">{{ $product->id }}</td>
            <td class="shop_page__all_products__item__title_product">
                <a href="{{ route('edit-shop-product', [$shop->id, $product->id]) }}">{{ $product->title }}</a>
            </td>
            <td class="shop_page__all_products__item__view_product">
                @if ( null !== $product->view_count){{ $product->view_count}}@else 0 @endif
            </td>
            <td class="shop_page__all_products__item__active_product">
                @if ($product->active == 1)
                    <form action="{{ route('deactivate-shop-product', [$shop->id, $product->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="product_active_btn" title="Нажмите чтобы убрать товар из наличия">Да</button>
                    </form>
                @else
                    <form action="{{ route('activate-shop-product', [$shop->id, $product->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="product_deactive_btn" title="Нажмите чтобы добавить товар в асортимент">Нет</button>
                    </form>
                @endif
            </td>
            <td @if ($product->moderate == 1) class="product_item__moderate_product" @else class="product_item__none_moderate_product" @endif>
                @if ($product->moderate == 1)
                <i class="fas fa-check-circle" title="Товар прошел модерацию"></i>
                @else
                <i class="fas fa-minus-circle" title="Товар находиться на модерации"></i>
                @endif
            </td>
            <td class="shop_page__all_products__item__control_product">
                <a href="{{ route('review-shop-product', [$shop->id, $product->id]) }}" title="Отзывы к товару" class="control_product__review"><i class="far fa-comment"></i></a>
                <a href="{{ route('edit-shop-product', [$shop->id, $product->id]) }}" title="Редактировать товар" class="control_product__edit"><i class="far fa-edit"></i></a>
                <form action="{{ route('delete-shop-product', [$shop->id, $product->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="control_product__delete" type="submit" title="Удалить товар" data-title="{{ $product->title }}"><i class="far fa-window-close"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<div class="shop_page__paginate">
{{ $products->links('pagination.paginate') }}
</div>
@endif
@endsection
