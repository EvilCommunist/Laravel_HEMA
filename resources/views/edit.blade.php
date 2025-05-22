@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush

@section('content')
<div class="store">
    @if($product)
        <div class="vertical-text top decor">{{ $displayCategory }}</div>
        <div class="vertical-text bottom decor">{{ $displayCategory }}</div>
        <div class="container flex">
            <section id="product_view">
                <section class="current_section">
                    <span class="cur_sub">
                        Каталог > {{ $product->category->name_of_type }} > {{ $product->name_of_prod }}
                    </span>
                </section>
                
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product->id) }}" id="product_form">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="existing_main_pic" value="{{ $product->main_image }}">
                    @foreach($product->images as $pic)
                        @if($pic && $pic !== $product->main_image)
                            <input type="hidden" name="existing_alt_pics[]" value="{{ $pic }}">
                        @endif
                    @endforeach
                    
                    <input type="text" id="edit_name" name="name" value="{{ old('name', $product->name_of_prod) }}" required>
                    
                    <div class="slider">
                        <div class="main-image">
                            @if($product->main_image)
                                <img id="main_image" src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name_of_prod }}">
                            @else
                                <div id="empty_image" class="empty-image">Нет изображения</div>
                            @endif
                        </div>
                        <div class="thumbnails" id="thumbnails">
                            @if($product->main_image)
                                <div class="thumbnail active" data-index="0">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="Thumbnail 1">
                                    <button type="button" class="remove_image">Х</button>
                                </div>
                            @endif
                            
                            @foreach($product->images as $index => $pic)
                                @if($pic && $pic !== $product->main_image)
                                    <div class="thumbnail" data-index="{{ $index + 1 }}">
                                        <img src="{{ asset('storage/' . $pic) }}" alt="Thumbnail {{ $index + 2 }}">
                                        <button type="button" class="remove_image">Х</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <input type="file" id="image_upload" name="new_images[]" accept="image/*" multiple>
                    </div>
                    
                    <section id="character_and_cart">
                        <section id="character">
                            <span id="cha">Характеристики</span>
                            <ul id="characteristics_list">
                                @foreach(old('characteristics', $product->characteristics->pluck('characteristic')->toArray()) as $char)
                                    <li>
                                        <input type="text" name="characteristics[]" class="edit_char" value="{{ $char }}" required>
                                        <button type="button" class="remove_char">Удалить</button>
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" id="add_char_btn" class="add_char_btn">+ Добавить характеристику</button>
                            
                            <div class="edit_section">
                                <label>Категория:</label>
                                <select id="product_category" class="edit_cat" name="cathegory" required>
                                    <option value="">Выберите категорию</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name_of_type }}" 
                                            {{ old('cathegory', $product->cathegory) == $category->name_of_type ? 'selected' : '' }}>
                                            {{ $category->name_of_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="edit_section">
                                <label>Цена:</label>
                                <input type="number" id="product_price" class="edit-price-input" name="price" 
                                    value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                            </div>
                            
                            <div class="edit_section">
                                <label>Количество на складе:</label>
                                <input type="number" id="product_remain" class="edit-stock-input" name="remain" 
                                       value="{{ old('remain', $product->remain) }}" min="0" required>
                            </div>
                            
                            <div class="edit_section">
                                <label>Описание:</label>
                                <textarea id="product_description" class="edit_desc" name="description" required>{{ 
                                    old('description', $product->description) }}</textarea>
                            </div>
                        </section>
                        
                        <div class="action_btns">
                            <button type="submit" id="save_btn" class="save_btn">Сохранить</button>
                            <a href="{{ route('admin') }}" id="cancel_btn" class="cancel_btn">Отмена</a>
                        </div>
                    </section>
                </form>
            </section>
        </div>
    @else
        <p>Товар не найден.</p>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const state = {
        tempImages: [],
        currentImageIndex: 0
    };

    const imageUpload = document.getElementById('image_upload');
    const addCharBtn = document.getElementById('add_char_btn');
    const form = document.getElementById('product_form');
    const thumbnails = document.getElementById('thumbnails');
    const mainImage = document.getElementById('main_image');
    const emptyImage = document.getElementById('empty_image');

    imageUpload.addEventListener('change', handleImageUpload);
    addCharBtn.addEventListener('click', addCharacteristic);
    
    document.querySelectorAll('.thumbnail .remove_image').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const index = parseInt(this.closest('.thumbnail').dataset.index);
            removeImage(index);
        });
    });
    
    document.querySelectorAll('.remove_char').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('li').remove();
        });
    });
    
    form.addEventListener('submit', function(e) {
        if (this.checkValidity()) {
            document.getElementById('save_btn').disabled = true;
            document.getElementById('save_btn').classList.add('saving');
        }
    });

    function handleImageUpload(event) {
        const files = Array.from(event.target.files);
        if (files.length === 0) return;
        
        const thumbnailsContainer = document.getElementById('thumbnails');
        
        files.forEach((file, index) => {
            createThumbnail(file, thumbnailsContainer.children.length);
        });
    }
    
    function createThumbnail(file, index) {
        const thumbnails = document.getElementById('thumbnails');
        const thumbnail = document.createElement('div');
        thumbnail.className = 'thumbnail';
        thumbnail.dataset.index = index;
        
        const img = document.createElement('img');
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        const removeBtn = document.createElement('button');
        removeBtn.className = 'remove_image';
        removeBtn.textContent = 'Х';
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            removeImage(index);
        });
        
        thumbnail.appendChild(img);
        thumbnail.appendChild(removeBtn);
        thumbnails.appendChild(thumbnail);
        
        thumbnail.addEventListener('click', function() {
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('main_image').src = img.src;
        });
    }
    
    function removeImage(index) {
        const thumbnails = document.getElementById('thumbnails');
        const thumbnail = thumbnails.querySelector(`.thumbnail[data-index="${index}"]`);
        if (!thumbnail) return;
        
        thumbnails.removeChild(thumbnail);
        
        if (index === 0) {
            const emptyImage = document.getElementById('empty_image');
            const mainImage = document.getElementById('main_image');
            if (emptyImage) emptyImage.style.display = 'flex';
            if (mainImage) mainImage.style.display = 'none';
        }
    }
    
    function addCharacteristic() {
        const list = document.getElementById('characteristics_list');
        const li = document.createElement('li');
        li.innerHTML = `
            <input type="text" name="characteristics[]" class="edit_char" required>
            <button type="button" class="remove_char">Удалить</button>
        `;
        li.querySelector('.remove_char').addEventListener('click', function() {
            li.remove();
        });
        list.appendChild(li);
    }
});
</script>
@endpush
@endsection