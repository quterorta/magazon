@extends('admin/admin-layouts/admin-layout')

@section('title')
AdminPanel | Applications #{{ $confirm->id }}
@endsection

@section('main-admin-content')
    <h1>Заявка #{{ $confirm->id }} для магазина "{{ $confirm->shop->title}}"</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="confirm_application_block">
        <div class="confirm_application_block__item">
            <h3>Проверка 1</h3>
            <p>{{ $confirm->text }}<br>На месте проверок будут либо документы либо другая нужная информация.</p>
        </div>
        <div class="confirm_application_block__item">
            <h3>Проверка 2</h3>
            <p>{{ $confirm->text_1 }}<br>Если нужно будет добавить документы или типо того, можно будет к кнопке отмены заявки добавить форму, в которой написать какую инфу нужно добавить, и потом отправить это на email, указанный в магазине</p>
        </div>
        <div class="confirm_application_block__item">
            <h3>Проверка 3</h3>
            <p>{{ $confirm->text_2 }}</p>
        </div>
        <div class="confirm_application_block__item">
            <a href="{{ route('shop.edit', $confirm->shop->id) }}">Ссылка на магазин "{{ $confirm->shop->title }}"</a>
        </div>

        <form action="{{ route('confirm.update', $confirm->id) }}" method="POST" class="fomr mt-3">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col d-grid">
                    <input type="submit" name="cancel" value="Отменить заявку" class="btn btn-danger">
                </div>
                <div class="col d-grid">
                    <input type="submit" name="confirm" value="Подтвердить заявку" class="btn btn-success">
                </div>
            </div>
        </form>

    </div>

@endsection
