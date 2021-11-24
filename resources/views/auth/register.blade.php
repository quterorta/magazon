@extends('layouts.layouts')

@section('title')
Înregistrare
@endsection

@section('auth-block')

<div class="auth_page__main_block">

    <div class="auth_page__container">
        <h1 class="auth_page__container__header">Înregistrare</h1>
        <br>
        <p class="auth_page__container__link">Ai deja un cont? <a href="{{ route('login') }}">Loghează-te</a></p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group form-input-field">
                <label for="name">Nume</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group form-input-field">
                <label for="email">E-mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group form-input-field">
                <label for="password">Parola</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group form-input-field">
                <label for="password-confirm">Confirmați parola</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="form-group form-radio-field">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user-role" id="user-role-buyer" value=0>
                    <label class="form-check-label" for="user-role-buyer">Sunt cumpărător</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user-role" id="user-role-seller" value=1>
                    <label class="form-check-label" for="user-role-seller">Sunt agent de vanzari</label>
                </div>
            </div>
            <div class="form-group d-grid">
                <button type="submit" class="auth-button">Înregistrează-te</button>
            </div>
        </form>
    </div>

</div>

@endsection
