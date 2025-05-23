@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endpush

@section('content')
<section class="store">
    <div class="vertical-text top decor">{{ $leftText }}</div>
    <div class="vertical-text bottom decor">{{ $rightText }}</div>
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
            @if($loading)
                <div>Загрузка...</div>
            @else
                <div id="catalog">
                    <section class="current_section">
                        <span class="cur">{{ $currentSection }}</span><br>
                        <span class="cur_sub">{{ $currentSubSection }}</span>
                    </section>
                    
                    @foreach($products as $product)
                    <div class="product">
                        <a href="{{ route('product.show', $product['id']) }}">
                            @if($mainImage = $product->main_image)
                            <img src="{{ asset('storage' . $mainImage) }}"
                                 alt="{{ $product->name_of_prod }}">
                            @else
                            <img src="{{ asset('images/placeholder.jpg') }}" 
                                 alt="Нет изображения">
                            @endif
                        </a>
                        <a href="{{ route('product.show', $product->id) }}">
                            <p class="prodName">{{ $product->name_of_prod }}</p>
                        </a>
                        <span class="descript">{{ $product->description}}</span>
                        <div class="prod_bottom">
                            Цена: {{ number_format($product['price'], 0, '', ' ') }} руб.
                            <button data-action="add-to-cart" 
                                    data-product-id="{{ $product->id }}">
                                В корзину
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обработка всех кнопок "В корзину"
        document.querySelectorAll('[data-action="add-to-cart"]').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const button = this;
                const originalText = button.textContent;
                
                button.disabled = true;
                button.textContent = 'Добавляем...';
                
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Товар добавлен в корзину');
                        updateCartCounters(data.cart);
                    } else {
                        alert(data.message || 'Ошибка при добавлении товара');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка');
                })
                .finally(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                });
            });
        });

        function updateCartCounters(cartData) {
            const totalItems = cartData.total;
            const totalPrice = cartData.price;
            
            const cartCounters = document.querySelectorAll('#cart_counter, #cart_counter_phone');
            const priceCounters = document.querySelectorAll('#price_counter, #price_counter_phone');
            
            if (cartCounters.length && priceCounters.length) {
                const priceText = `${totalPrice.toLocaleString('ru-RU')} рублей`;
                const itemText = `${totalItems} ${getNoun(totalItems, 'товар', 'товара', 'товаров')}`;
                
                cartCounters.forEach(counter => {
                    counter.innerHTML = `${itemText}<br><span id="price_counter">${priceText}</span>`;
                });
                
                priceCounters.forEach(counter => {
                    counter.textContent = priceText;
                });
            }
        }

        function getNoun(number, one, two, five) {
            let n = Math.abs(number);
            n %= 100;
            if (n >= 5 && n <= 20) {
                return five;
            }
            n %= 10;
            if (n === 1) {
                return one;
            }
            if (n >= 2 && n <= 4) {
                return two;
            }
            return five;
        }
    });
</script>
@endpush