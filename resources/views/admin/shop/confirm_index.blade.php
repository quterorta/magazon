@extends('admin/admin-layouts/admin-layout')

@section('title', 'AdminPanel | All applications for confirm')

@section('main-admin-content')
    <h1>Заявки на подтверждение магазинов</h1>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (isset($errors))
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $error }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
    @endif

    <div class="admin-subcategory-list">
        <table style="width: 100%">
            <tr>
                <th style="width: 10%">ID заявки</th>
                <th style="width: 30%">Название магазина</th>
                <th style="width: 30%">Дата заявки</th>
                <th style="width: 30%">Controls</th>
            </tr>
            @foreach ($confirms as $confirm)
            <tr>
                <td style="width: 10%">{{ $confirm->id }}</td>
                <td style="width: 30%">{{ $confirm->shop->title }}</td>
                <td style="width: 30%">{{ $confirm->created_at }}</td>
                <td style="width: 30%">
                    <a href="{{ route('confirm.show', $confirm->id) }}">Подтвердить заявку</a><br>
                    <form action="{{ route('confirm.destroy', $confirm->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" data-title="Заявка #{{ $confirm->id }}">Отменить заявку</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    {{ $confirms->links('pagination.paginate') }}

@endsection
