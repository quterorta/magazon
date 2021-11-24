@extends('layouts/layouts')

@section('title', 'Order success')

@section('main-content-block')

    <div class="order-success">
        <h2>Comanda #{{ $order->id }} a fost plasată cu succes.</h2>
        <p>Managerul nostru vă va contacta în scurt timp!</p>
        <div><a href="{{ route('cabinet') }}">În contul dvs. personal</a> <a href="{{ route('home') }}">La principal</a> <a href="{{ route('catalog') }}">La cumparaturi</a></div>
    </div>

@endsection
