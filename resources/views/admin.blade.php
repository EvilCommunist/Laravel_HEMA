@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div id="content-section">
    <section class="store">
        <div class="container flex">
            <aside id="menu">
                        <span id="nameSection"><a href="?">Каталог</a></span>
                        <hr>
                        <ul>
                            <li>
                                <span id="sub_section">Защита</span>
                                <ul>
                                    <li><a href="?category=Защита головы">Защита головы</a></li>
                                    <li><a href="?category=Защита тела">Защита тела</a></li>
                                    <li><a href="?category=Защита рук">Защита рук</a></li>
                                    <li><a href="?category=Защита ног">Защита ног</a></li>
                                </ul>
                            </li>
                            <hr>
                            <li>
                                <span id="sub_section">Оружие</span>
                                <ul>
                                    <li><a href="?category=Древковое">Древковое</a></li>
                                    <li><a href="?category=Колющее">Колющее</a></li>
                                    <li><a href="?category=Режущее оружие">Режущее оружие</a></li>
                                    <li><a href="?category=Луки">Луки</a></li>
                                    <li><a href="?category=Тренировочное">Тренировочное</a></li>
                                </ul>
                            </li>
                            <hr>
                            <li>
                                <span id="sub_section">Комплекты</span>
                                <ul>
                                    <li><a href="?category=Русские комплекты">Русские комплекты</a></li>
                                    <li><a href="?category=Азиатские комплекты">Азиатские комплекты</a></li>
                                    <li><a href="?category=Европейские комплекты">Европейские комплекты</a></li>
                                    <li><a href="?category=Арабские комплекты">Арабские комплекты</a></li>
                                </ul>
                            </li>
                        </ul>
                    </aside>
            <section>
                <div id="catalog">
                    <section class="current_section">
                        <span class="cur">{{ $currentCategory ?? 'Все товары' }}</span><br>
                    </section>
                    
                    @foreach($products as $product)
                    <div class="product">
                        @if($mainImage = $product->main_image)
                        <img src="{{ asset('storage' . $mainImage) }}" 
                            alt="{{ $product->name_of_prod }}"
                            onclick="location.href='{{ route('admin.products.edit', $product->id) }}'">
                        @else
                        <img src="{{ asset('images/placeholder.jpg') }}" 
                            alt="Нет изображения">
                        @endif
                        <p>{{ $product->name_of_prod }}</p>
                        <span class="descript">{{ $product->description }}</span>
                        <div class="prod_bottom">
                            <button class="plus" onclick="/*updateQuantity({{ $product->id }}, 'increase')*/">+</button>
                            На складе: <span id="remain-{{ $product->id }}">{{ $product->remain }}</span> шт.
                            <button class="minus" onclick="/*updateQuantity({{ $product->id }}, 'decrease')*/">-</button>
                            <button class="change" onclick="location.href='{{ route('admin.products.edit', $product->id) }}'">Редактировать</button>
                        </div>
                    </div>
                    @endforeach
                    
                    <div id="new_one" class="product" onclick="location.href='{{ route('admin.products.create') }}'">
                        <span id="big_plus">+</span>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>

<script>
function updateQuantity(productId, action) {
    fetch(`/admin/products/${productId}/quantity`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ action: action })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(`remain-${productId}`).textContent = data.remain;
    });
}
</script>
@endsection