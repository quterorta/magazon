@extends('layouts.layouts')

@section('title')
Reseteaza parola
@endsection

@section('auth-block')
<div class="auth_page__main_block">

    <div class="auth_page__container">
        <h1 class="auth_page__container__header">Reseteaza parola</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group form-input-field">
                <label for="email" >E-mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="auth-button mt-4">Trimiteți linkul de resetare a parolei</button>
            </div>
        </form>
    </div>
</div>
@endsection
