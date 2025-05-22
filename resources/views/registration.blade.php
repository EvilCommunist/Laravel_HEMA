@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')

<div id="form" class="container flex">
<form id="regForm" method="POST">
    @CSRF
    <div class="auth">
    <label>ФИО</label><br>
    <input type="text" name="fio" required>
    <div class="error-message" id="name-error"></div>
    </div>
    <div class="auth">
    <label>Email (логин)</label><br>
    <input type="email" name="login" required>
    <div class="error-message" id="email-error"></div>
    </div>
    <div class="auth">
    <label>Номер телефона (пример: 89007775544)</label><br>
    <input type="tel" name="tele_number" required>
    <div class="error-message" id="phone-error"></div>
    </div>
    <div class="auth">
    <label>Пароль</label><br>
    <input type="password" name="passwd_hash" required>
    <div class="error-message" id="password-error"></div>
    </div>
    <div class="auth">
    <label>Подтвердите пароль</label><br>
    <input type="password" name="confirmPassword" required>
    <div class="error-message" id="confirmPassword-error"></div>
    </div>
    <button type="submit" id="reg">Зарегистрироваться</button>
</form>
</div>
@endsection