@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All orders')

@section('main-admin-content')
    <h1>Все заказы</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div>
        <table style="width: 100%;">
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 17.5%;">Статус</th>
                <th style="width: 17.5%;">Товары</th>
                <th style="width: 17.5%;">Данные о доставке</th>
                <th style="width: 17.5%;">Дата заказа</th>
                <th style="width: 10%">Control</th>
            </tr>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>
                    @if ($order->status == 0)
                    <p>Оформлен</p>
                    @elseif($order->status == 1)
                    <p>Подтвержден</p>
                    @elseif($order->status == 2)
                    <p>Выполнен</p>
                    @elseif($order->status == 3)
                    <p>Отменен</p>
                    @endif
                </td>
                <td>
                    @foreach ($order->products->unique() as $product)
                    <p><a href="">{{ $product->title }}</a> x {{ $order->products->countBy('id')[$product->id] }}</p>
                    @endforeach
                </td>
                <td>
                    {{ $order->country->title }}<br>
                    {{ $order->region->title }}<br>
                    {{ $order->city->title }}<br>
                    {{ $order->adress_shipment }}<br>
                </td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{ route('order.edit', $order->id) }}">Редактировать</a>
                    <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="{{ $order->id }}">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $orders->links('pagination.paginate') }}

@endsection
