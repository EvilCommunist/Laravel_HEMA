@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<!--Секция "приветствия"-->
<section id="advert">
  <div class="container flex">
    <h1>Лучшее снаряжение для исторических европейских боевых искусств</h1>
    <section id="showMore">
      <h2>Узнать подробнее</h2><br>
      <svg width="86" height="86" viewBox="0 0 86 86" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="43" cy="43" r="40.5" stroke="white" stroke-width="5"/>
      <path d="M45.5 24C45.5 22.6193 44.3807 21.5 43 21.5C41.6193 21.5 40.5 22.6193 40.5 24L45.5 24ZM41.2322 63.7678C42.2085 64.7441 43.7915 64.7441 44.7678 63.7678L60.6777 47.8579C61.654 46.8816 61.654 45.2986 60.6777 44.3223C59.7014 43.346 58.1184 43.346 57.1421 44.3223L43 58.4645L28.8579 44.3223C27.8816 43.346 26.2986 43.346 25.3223 44.3223C24.346 45.2986 24.346 46.8816 25.3223 47.8579L41.2322 63.7678ZM40.5 24L40.5 62L45.5 62L45.5 24L40.5 24Z" fill="white"/>
      </svg>
    </section>
  </div>
  <img src="{{ asset('assets/bannerSword.png') }}">
</section>
<!--Секция "преимущества"-->
<section id="advantages" class="container flex">
  <div class="advantage">
    <img src="{{ asset('assets/ShopCart.png') }}">
    <span class="advheader"><br>Широкий ассортимент</span>
    <span class="advtext">Предложение разнообразного снаряжения, включая мечи, щиты, броню и другие аксессуары</span>
  </div>
  <div class="advantage">
    <img src="{{ asset('assets/Delivery.png') }}">
    <span class="advheader"><br>Доставка на дом</span>
    <span class="advtext">Удобная доставка прямо к порогу клиента, что экономит время и усилия</span>
  </div>
  <div class="advantage">
    <img src="{{ asset('assets/paint.png') }}">
    <span class="advheader"><br>Кастомизация товаров</span>
    <span class="advtext">Возможность заказа индивидуальных и кастомизированных предметов с учетом предпочтений клиентов</span>
  </div>
  <div class="advantage">
    <img src="{{ asset('assets/expand.png') }}">
    <span class="advheader"><br>Точные размеры и описания</span>
    <span class="advtext">Подробные спецификации и размеры товаров, что позволяет избежать ошибок при покупке</span>
  </div>
  <div class="advantage">
    <img src="{{ asset('assets/dealHands.png') }}">
    <span class="advheader"><br>Поддержка культурных мероприятий</span>
    <span class="advtext">Участие в фестивалях и турнирах, что содействует популяризации боевых искусств</span>
  </div>
  <div class="advantage">
    <img src="{{ asset('assets/10yrs.png') }}">
    <span class="advheader"><br>Долгосрочная репутация</span>
    <span class="advtext">Мы успешно работаем на рынке уже 10 лет, что обеспечивает доверие наших клиентов и партнеров.</span>
  </div>
</section>
<!--Секция с предложением совершить покупку-->
<section id="advShop">
  <div class="container flex">
    <h1>Приобретайте качественную экипировку по приятным ценам!</h1>
    <a href="{{ route('store') }}"><button>Перейти в каталог</button></a>
  </div>
  <img src="{{ asset('assets/swordsman.png') }}">
</section>
@endsection