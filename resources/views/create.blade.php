@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('content')
<div class="store">
    <div>
        <div class="vertical-text top decor">Добавить новый</div>
        <div class="vertical-text bottom decor">Добавить новый</div>
        <div class="container flex">
            <section id="product_view">
                <section class="current_section">
                    <span class="cur_sub">Каталог > Добавить новый</span>
                </section>
                
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}" id="product_form">
                    @csrf
                    
                    <input type="text" id="edit_name" name="name" placeholder="Название товара" value="{{ old('name') }}" required>
                    
                    <div class="slider">
                        <div class="main-image">
                            <img id="main_image" src="" alt="Превью изображения" style="display: none;">
                            <div id="empty_image" class="empty-image">Добавьте изображение</div>
                        </div>
                        <div id="thumbnails" class="thumbnails"></div>
                        
                        <input type="file" id="main_image_upload" name="main_pic" accept="image/*" style="display: none;">
                        <input type="file" id="alt_images_upload" name="alt_pics[]" accept="image/*" multiple style="display: none;">
                        
                        <div class="upload-buttons">
                            <button type="button" id="upload_main_btn" class="upload-btn">Добавить главное фото</button>
                            <button type="button" id="upload_alt_btn" class="upload-btn">Добавить дополнительные фото</button>
                        </div>
                    </div>
                    
                    <section id="character_and_cart">
                        <section id="character">
                            <span id="cha">Характеристики</span>
                            <ul id="characteristics_list">
                                @foreach(old('characteristics', []) as $char)
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
                                        <option value="{{ $category->name_of_type }}" {{ old('cathegory') == $category->name_of_type ? 'selected' : '' }}>
                                            {{ $category->name_of_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="edit_section">
                                <label>Цена:</label>
                                <input type="number" id="product_price" class="edit-price-input" name="price" 
                                       value="{{ old('price', 0) }}" min="0" step="0.01" required>
                            </div>
                            
                            <div class="edit_section">
                                <label>Количество на складе:</label>
                                <input type="number" id="product_remain" class="edit-stock-input" name="remain" 
                                       value="{{ old('remain', 0) }}" min="0" required>
                            </div>
                            
                            <div class="edit_section">
                                <label>Описание:</label>
                                <textarea id="product_description" class="edit_desc" placeholder="Описание товара" 
                                          name="description" required>{{ old('description') }}</textarea>
                            </div>
                        </section>
                        
                        <div class="action_btns">
                            <button type="submit" id="save_btn" class="save_btn">Добавить товар</button>
                            <a href="{{ route('admin') }}" id="cancel_btn" class="cancel_btn">Отмена</a>
                        </div>
                    </section>
                </form>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const state = {
        mainImage: null,
        altImages: []
    };

    // Элементы DOM
    const form = document.getElementById('product_form');
    const mainImageUpload = document.getElementById('main_image_upload');
    const altImagesUpload = document.getElementById('alt_images_upload');
    const uploadMainBtn = document.getElementById('upload_main_btn');
    const uploadAltBtn = document.getElementById('upload_alt_btn');
    const mainImageElement = document.getElementById('main_image');
    const emptyImage = document.getElementById('empty_image');
    const thumbnails = document.getElementById('thumbnails');
    const addCharBtn = document.getElementById('add_char_btn');
    const characteristicsList = document.getElementById('characteristics_list');
    const cancelBtn = document.getElementById('cancel_btn');

    // Обработчики событий
    uploadMainBtn.addEventListener('click', () => mainImageUpload.click());
    uploadAltBtn.addEventListener('click', () => altImagesUpload.click());
    mainImageUpload.addEventListener('change', handleMainImageUpload);
    altImagesUpload.addEventListener('change', handleAltImagesUpload);
    addCharBtn.addEventListener('click', addCharacteristic);
    form.addEventListener('submit', handleFormSubmit);

    function handleMainImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        state.mainImage = file;
        previewImage(file, mainImageElement);
        
        if (emptyImage) emptyImage.style.display = 'none';
        if (mainImageElement) mainImageElement.style.display = 'block';
        
        updateThumbnails();
    }
    
    function handleAltImagesUpload(event) {
        const files = Array.from(event.target.files);
        if (files.length === 0) return;
        
        state.altImages = [...state.altImages, ...files];
        updateThumbnails();
        
        if (!state.mainImage && files.length > 0) {
            state.mainImage = files[0];
            previewImage(files[0], mainImageElement);
            if (emptyImage) emptyImage.style.display = 'none';
            if (mainImageElement) mainImageElement.style.display = 'block';
        }
    }
    
    function previewImage(file, targetElement) {
        const reader = new FileReader();
        reader.onload = function(e) {
            targetElement.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    
    function updateThumbnails() {
        thumbnails.innerHTML = '';
        
        const allImages = state.mainImage ? [state.mainImage, ...state.altImages] : [...state.altImages];
        
        allImages.forEach((file, index) => {
            const thumbnail = document.createElement('div');
            thumbnail.className = 'thumbnail';
            thumbnail.dataset.index = index;
            
            const img = document.createElement('img');
            previewImage(file, img);
            
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
                mainImageElement.src = img.src;
            });
        });
    }
    
    function removeImage(index) {
        if (index === 0 && state.mainImage) {
            state.mainImage = state.altImages.length > 0 ? state.altImages.shift() : null;
            
            if (!state.mainImage) {
                if (emptyImage) emptyImage.style.display = 'flex';
                if (mainImageElement) mainImageElement.style.display = 'none';
            } else {
                previewImage(state.mainImage, mainImageElement);
            }
        } else {
            const altIndex = state.mainImage ? index - 1 : index;
            if (altIndex >= 0 && altIndex < state.altImages.length) {
                state.altImages.splice(altIndex, 1);
            }
        }
        
        updateThumbnails();
    }
    
    function addCharacteristic() {
        const li = document.createElement('li');
        li.innerHTML = `
            <input type="text" name="characteristics[]" class="edit_char" required>
            <button type="button" class="remove_char">Удалить</button>
        `;
        li.querySelector('.remove_char').addEventListener('click', function() {
            li.remove();
        });
        characteristicsList.appendChild(li);
    }
    
    function handleFormSubmit(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            alert('Пожалуйста, заполните все обязательные поля');
            return;
        }
        
        if (!state.mainImage && state.altImages.length === 0) {
            alert('Пожалуйста, добавьте хотя бы одно изображение товара');
            return;
        }
        
        form.submit();
    }
});
</script>
@endpush
@endsection