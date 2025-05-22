@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<main>
    <!-- Product card section -->
    <div class="store">
        @if($product)
            <div class="vertical-text top decor">{{ $displayCategory }}</div>
            <div class="vertical-text bottom decor">{{ $displayCategory }}</div>
            <div class="container flex">
                <section id="product_view">
                    <section class="current_section">
                        <span class="cur">
                            {{ $product->name_of_prod }}
                        </span><br>
                        <span class="cur_sub">
                            {{ $breadcrumbs }}
                        </span>
                    </section>
                    <div class="slider">
                        <!-- Main image -->
                        <div class="main-image">
                        <img id="mainProductImage" src="{{ $allImages[0] }}" alt="{{ $product->name_of_prod }}" />
                    </div>
                    <div class="thumbnails">
                        @foreach($allImages as $index => $image)
                            <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="changeImage({{ $index }})">
                                <img src="{{ $image }}" alt="Превью {{ $index + 1 }}" />
                            </div>
                        @endforeach
                    </div>
                    </div>
                </section>
                <!-- Characteristics and add to cart button -->
                <section id="character_and_cart">
                    <section id="character">
                        <span id="cha">Характеристики</span>
                        <ul>
                            @foreach($product->characteristics as $char)
                                <li><span class="marker">></span> {{ $char->characteristic }}</li>
                            @endforeach
                        </ul>
                    </section>
                    <button data-action="add-to-cart" data-product-id="{{ $product->id }}">В корзину</button>
                </section>
            </div>
        @elseif($loading)
            <p>Загрузка...</p>
        @else
            <p>Товар не найден.</p>
        @endif
    </div>
</main>

@push('scripts')
<script>
    const allImages = @json($allImages ?? []);
    let currentImageIndex = 0;
    let autoSlideInterval = null;

    function changeImage(index) {
        currentImageIndex = index;
        document.getElementById('mainProductImage').src = allImages[index];
        
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
        
        stopAutoSlide();
        startAutoSlide();
    }

    function prevImage() {
        const newIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
        changeImage(newIndex);
    }

    function nextImage() {
        const newIndex = (currentImageIndex + 1) % allImages.length;
        changeImage(newIndex);
    }

    function startAutoSlide() {
        if (allImages.length > 1) {
            autoSlideInterval = setInterval(nextImage, 3000);
        }
    }

    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }

    function addToCart(productId) {
        fetch('/api/add_to_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ productId: productId })
        })
        .then(response => response.json())
        .then(data => {
            alert('Товар добавлен в корзину');
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        startAutoSlide();
        
        document.querySelector('[data-action="add-to-cart"]').addEventListener('click', function() {
            addToCart(this.dataset.productId);
        });
    });
</script>
@endpush
@endsection