@extends('layouts.layouts')

@section('title')
Autentificare
@endsection

@section('auth-block')

<div class="auth_page__main_block">

    <div class="auth_page__container">
        <h1 class="auth_page__container__header">Autentificare</h1>
        <br>
        <p class="auth_page__container__link">Nu aveți încă un cont? <a href="{{ route('register') }}">Înregistrează-te acum</a></p>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="form-group form-input-field">
                <label for="email">E-mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group form-input-field">
                <label for="password">Parola</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group form-check-field">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Amintește-ți de mine</label>
                </div>
            </div>

            <div class="form-group form-forgot-link">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Ti-ai uitat parola?') }}
                    </a>
                @endif
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="auth-button">Autentificare</button>
            </div>
        </form>

    </div>
</div>

@endsection
