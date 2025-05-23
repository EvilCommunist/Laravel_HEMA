@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<main>
  <!--Секция корзины с товарами-->
  <section class="store">
    <div id="cart" class="container flex">
      <section class="current_section">
        <span class="cur">Корзина</span><br>
        <span class="cur_sub">Главная > Корзина</span>
      </section>
      
      <div id="cart-content">
        @if(count($cartItems['items'] ?? []) > 0)
          <div class="make_wider">
            <section id="items">
              @foreach($cartItems['items'] as $item)
                <div class="item" data-id="{{ $item['id'] }}">
                  <div class="img_holder">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"/>
                  </div>
                  <div class="item_text">
                    <div class="part_one">    
                      <p class="item_name">{{ $item['name'] }}</p>
                      <div class="counter">
                        <button data-action="decrease" data-product-id="{{ $item['id'] }}" class="minus">-</button>
                        <span class="item_count">{{ $item['quantity'] }}</span>
                        <button data-action="increase" data-product-id="{{ $item['id'] }}" class="plus">+</button>
                      </div>
                    </div>
                    <p class="item_price">{{ number_format($item['price'] * $item['quantity'], 0, '', ' ') }} руб.</p>
                  </div>
                </div>
              @endforeach
            </section>
            <hr>
            <section id="order">
              <section id="form_pay_section">
                <section id="formsection">
                  <span id="finishing">Оформление заказа</span>
                  <form id="order-form" class="order-form">
                    @csrf
                    <div class="form-group">
                      <label for="fullName">ФИО<span class="red_star">*</span></label>
                      <input type="text" id="fullName" name="fullName" required />
                      <span id="fullNameError" class="error"></span>
                    </div>
                    <div class="form-group">
                      <label for="phone">Номер телефона<span class="red_star">*</span></label>
                      <input type="tel" id="phone" name="phone" required />
                      <span id="phoneError" class="error"></span>
                    </div>
                    <div class="form-group">
                      <label for="address">Адрес доставки<span class="red_star">*</span></label>
                      <input type="text" id="address" name="address" required />
                      <span id="addressError" class="error"></span>
                    </div>
                    <div class="form-group">
                      <label for="comment">Комментарий к заказу</label>
                      <textarea id="comment" name="comment"></textarea>
                    </div>
                  </form>
                </section>
                <section id="paysection">
                  <div class="pay_info"><p>Итоговая стоимость заказа:</p> <p>{{ number_format($cartItems['price'], 0, '', ' ') }} руб.</p></div>
                  <div class="pay_info">
                    <p>Способ оплаты:</p>
                    <select id="paymentMethod" name="paymentMethod" required>
                      <option value="cash">Наличными при получении</option>
                      <option value="card">Онлайн-оплата картой</option>
                      <option value="bankTransfer">Банковский перевод</option>
                    </select>
                  </div>
                  <button id="submit-order">Оформить заказ</button>
                  <p id="alert">*После оформления заказа с вами свяжется менеджер</p>
                </section>
              </section>
            </section>
          </div>
        @else
          <p>Корзина пуста</p>
        @endif
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-action="add-to-cart"]').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        
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
        });
      });
    });

    document.querySelectorAll('[data-action="increase"], [data-action="decrease"]').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const action = this.dataset.action;
        
        fetch('/cart/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ 
            product_id: productId,
            action: action
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            updateCartCounters(data.cart);
            location.reload(); 
          } else {
            alert(data.message || 'Ошибка при обновлении корзины');
          }
        });
      });
    });

    document.getElementById('submit-order').addEventListener('click', function() {
      const form = document.getElementById('order-form');
      const formData = new FormData(form);
      formData.append('paymentMethod', document.getElementById('paymentMethod').value);

      fetch('/order/process', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Заказ оформлен! Номер: ' + data.orderId);
          window.location.href = '/';
        } else {
          // Show validation errors
          if (data.errors) {
            Object.keys(data.errors).forEach(field => {
              const errorElement = document.getElementById(field + 'Error');
              if (errorElement) {
                errorElement.textContent = data.errors[field][0];
              }
            });
          } else {
            alert(data.message || 'Ошибка при оформлении заказа');
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при оформлении заказа');
      });
    });

    function updateCartCounters(cartData) {
      const totalItems = cartData.total;
      const totalPrice = cartData.price;
      
      // Update counters in header
      const cartCounters = document.querySelectorAll('#cart_counter, #cart_counter_phone');
      const priceCounters = document.querySelectorAll('#price_counter, #price_counter_phone');
      
      if (cartCounters.length && priceCounters.length) {
        const priceText = `${totalPrice.toLocaleString('ru-RU')} рублей`;
        const itemText = `${totalItems} ${getNoun(totalItems, 'товар', 'товара', 'товаров')}`;
        
        cartCounters.forEach(counter => {
          counter.innerHTML = `${itemText}<br><span>${priceText}</span>`;
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
@endsection