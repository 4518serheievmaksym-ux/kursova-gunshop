@extends('layout')

@section('content')

<style>
    /* --- СТИЛІ ФОРМИ СТВОРЕННЯ (GUNSHOP STYLE) --- */
    .create-card {
        background-color: #18181b;
        border: 1px solid #333;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .create-header {
        background: linear-gradient(90deg, #202023 0%, #18181b 100%);
        padding: 25px 30px;
        border-bottom: 1px solid #333;
        border-left: 5px solid var(--gun-accent);
    }

    .form-title {
        font-family: 'Oswald', sans-serif;
        color: #fff;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 1.5rem;
    }

    /* Секції форми */
    .form-section-title {
        color: var(--gun-accent);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .form-section-title::after {
        content: ''; flex-grow: 1; height: 1px; background-color: #333; margin-left: 15px;
    }

    .form-label-gun {
        color: #a1a1aa;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    /* Інпути */
    .form-control-gun, .form-select-gun {
        background-color: #0a0a0a;
        border: 1px solid #444;
        color: #fff;
        border-radius: 4px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: 0.3s;
    }
    .form-control-gun:focus, .form-select-gun:focus {
        background-color: #000;
        border-color: var(--gun-accent);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        color: #fff;
    }
    
    /* Зона завантаження фото */
    .upload-zone {
        border: 2px dashed #444;
        background-color: #121214;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        transition: 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .upload-zone:hover {
        border-color: var(--gun-accent);
        background-color: #161618;
    }
    .upload-icon { font-size: 3rem; color: #555; margin-bottom: 10px; transition: 0.3s; }
    .upload-zone:hover .upload-icon { color: var(--gun-accent); }
    
    /* Прев'ю картинки */
    #preview-container {
        display: none;
        margin-top: 20px;
        position: relative;
    }
    #preview-img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 1px solid #333;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    /* Кнопки */
    .btn-save {
        background-color: var(--gun-accent);
        color: #000;
        font-family: 'Oswald', sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        padding: 12px 40px;
        border: none;
        transition: 0.3s;
        border-radius: 4px;
    }
    .btn-save:hover { background-color: #fff; box-shadow: 0 0 20px rgba(249, 115, 22, 0.5); }
    
    .btn-back {
        color: #888;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: 0.3s;
        display: flex; align-items: center;
    }
    .btn-back:hover { color: #fff; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            {{-- Хлібні крихти --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i> Повернутися до Арсеналу
                </a>
            </div>

            <div class="create-card">
                <div class="create-header">
                    <h1 class="form-title">
                        <i class="bi bi-box-seam me-2 text-warning"></i> Реєстрація товару
                    </h1>
                </div>

                <div class="p-5">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- СЕКЦІЯ 1: ОСНОВНА ІНФОРМАЦІЯ --}}
                        <div class="form-section-title">Базові дані</div>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-12">
                                <label class="form-label-gun">Назва моделі <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-gun" placeholder="Наприклад: Glock 17 Gen5 (CO2)" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-gun">Категорія <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select form-select-gun" required>
                                    <option value="" disabled selected>Виберіть тип озброєння...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-gun">Вартість (UAH) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" step="0.01" class="form-control form-control-gun" placeholder="0.00" required>
                                    <span class="input-group-text bg-dark border-secondary text-muted">₴</span>
                                </div>
                            </div>
                        </div>

                        {{-- СЕКЦІЯ 2: ОПИС --}}
                        <div class="form-section-title">Технічна специфікація</div>
                        
                        <div class="mb-5">
                            <label class="form-label-gun">Детальний опис</label>
                            <textarea name="description" rows="8" class="form-control form-control-gun" placeholder="Опишіть характеристики, комплектацію, особливості..."></textarea>
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-code-slash me-1"></i> Підтримується HTML форматування.
                            </div>
                        </div>

                        {{-- СЕКЦІЯ 3: МЕДІА --}}
                        <div class="form-section-title">Фотофіксація</div>

                        <div class="mb-5">
                            <label class="upload-zone" for="imageUpload">
                                <input type="file" name="image" id="imageUpload" class="d-none" accept="image/*" onchange="previewImage(event)">
                                <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                <h6 class="text-white mb-1">Натисніть для завантаження фото</h6>
                                <p class="text-muted small mb-0">JPG, PNG або WEBP (Макс. 5MB)</p>
                            </label>

                            {{-- Блок для прев'ю --}}
                            <div id="preview-container" class="text-center">
                                <p class="text-warning small mb-2 text-uppercase fw-bold">Попередній перегляд:</p>
                                <img id="preview-img" src="#" alt="Preview">
                            </div>
                        </div>

                        {{-- ФУТЕР --}}
                        <div class="d-flex justify-content-end pt-4 border-top border-secondary">
                            <button type="submit" class="btn-save">
                                <i class="bi bi-check-lg me-2"></i> Додати до Арсеналу
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Скрипт для попереднього перегляду зображення
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            output.src = reader.result;
            document.getElementById('preview-container').style.display = 'block';
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

@endsection