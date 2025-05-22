@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')

<div id="form" class="container flex">
    @if($errors->any())
                @foreach($errors->all() as $error)
                    <p class="form__error">{{$error}}</p>
                @endforeach
            @endif
<form id="loginForm" method="POST">
    @CSRF
    <div class="auth">
    <label>Email (логин)</label><br>
    <input type="email" name="login" required>
    <div class="error-message" id="email-error"></div>
    </div>
    <div class="auth">
    <label>Пароль</label><br>
    <input type="password" name="passwd_hash" required>
    <div class="error-message" id="password-error"></div>
    </div>
    <button type="submit" id="submitBtn">Войти</button>
</form>
</div>
@endsection