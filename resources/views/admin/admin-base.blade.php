@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | Main')

@section('main-admin-content')
    <div class="admin_page">
        <h1 class="admin_page__main_header">Panoul de administrare | Acasă</h1>
        <div class="admin_page__grid_3">

            <div class="admin_page__grid_item__statistic_card admin_page__grid_item__statistic_card__products">
                @if ($new_product_admin_marker !== 0)
                    <div class="admin_page__grid_item__statistic_card__new_badge">
                        <a href="{{ route('product.premoderate') }}" title="În curs de moderare">{{$new_product_admin_marker}}</a>
                    </div>
                    @endif
                <div class="admin_page__grid_item__statistic_card__top_section">
                    <div class="admin_page__grid_item__statistic_card__top_section__icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="admin_page__grid_item__statistic_card__top_section__text">
                        <p>{{ $products->count() }}</p>
                        <span>Moderat: <b>{{ $moderated_products->count() }}</b></span>
                    </div>
                </div>
                <div class="admin_page__grid_item__statistic_card__bottom_section">
                    <a href="{{ route('product.index') }}">Toate mărfurile</a>
                </div>
            </div>

            <div class="admin_page__grid_item__statistic_card admin_page__grid_item__statistic_card__orders">
                @if ($new_order_admin_marker !== 0)
                    <div class="admin_page__grid_item__statistic_card__new_badge">
                        <a href="{{ route('order.index') }}/?status=0" title="Noi comenzi">{{$new_order_admin_marker}}</a>
                    </div>
                    @endif
                <div class="admin_page__grid_item__statistic_card__top_section">
                    <div class="admin_page__grid_item__statistic_card__top_section__icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="admin_page__grid_item__statistic_card__top_section__text">
                        <p>{{ $orders->count() }}</p>
                        <span title="Noi comenzi" class="new_orders_badge">{{ $new_orders }}</span>
                        <span title="Comenzi confirmate" class="confirmed_orders_badge">{{ $confirmed_orders }}</span>
                        <span title="Comenzi finalizate" class="completed_orders_badge">{{ $completed_orders }}</span>
                        <span title="Comenzi anulate" class="canceled_orders_badge">{{ $canceled_orders }}</span>
                    </div>
                </div>
                <div class="admin_page__grid_item__statistic_card__bottom_section">
                    <a href="{{ route('order.index') }}">Toate comenzile</a>
                </div>
            </div>

            <div class="admin_page__grid_item__statistic_card admin_page__grid_item__statistic_card__costs">
                <div class="admin_page__grid_item__statistic_card__top_section">
                    <div class="admin_page__grid_item__statistic_card__top_section__icon"><i class="fas fa-coins"></i></div>
                    <div class="admin_page__grid_item__statistic_card__top_section__text">
                        <p>{{ $total_cost }} MDL</p>
                        <span>Comision: {{ $total_cost*0.1 }} MDL (10%)</span>
                    </div>
                </div>
                <div class="admin_page__grid_item__statistic_card__bottom_section">
                    <a href="{{ route('order.index') }}">Toate comenzile</a>
                </div>
            </div>

            <div class="admin_page__grid_item__statistic_card admin_page__grid_item__statistic_card__users">
                @if ($new_confirm_admin_marker !== 0)
                    <div class="admin_page__grid_item__statistic_card__new_badge">
                        <a href="{{ route('confirm.index') }}" title="Cereri de confirmare">{{$new_confirm_admin_marker}}</a>
                    </div>
                @endif
                <div class="admin_page__grid_item__statistic_card__top_section">
                    <div class="admin_page__grid_item__statistic_card__top_section__icon"><i class="fas fa-users"></i></div>
                    <div class="admin_page__grid_item__statistic_card__top_section__text">
                        <p>{{ $users }}</p>
                        <span>Magazine: <a href="{{route('shop.index')}}">{{ $shops }}</a></span>
                    </div>
                </div>
                <div class="admin_page__grid_item__statistic_card__bottom_section">
                    <a href="{{ route('user.index') }}">Toți utilizatorii</a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('admin-side-filter')
@endsection
