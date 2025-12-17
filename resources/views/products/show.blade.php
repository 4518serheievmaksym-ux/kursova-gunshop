@extends('layout')

@section('content')

<style>
    /* --- СТИЛІ ДЛЯ БІЛОЇ ПАНЕЛІ ПРОДУКТУ --- */
    .product-white-panel {
        background-color: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        padding: 40px;
        margin-top: 40px;
        margin-bottom: 60px;
        color: #333;
    }

    /* Зображення */
    .product-gallery {
        background-color: #fff;
        padding: 20px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 500px;
    }
    .product-gallery img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));
    }

    /* Заголовок та Ціна */
    .product-white-panel .section-title {
        font-family: 'Oswald', sans-serif;
        font-size: 2.5rem;
        color: #111;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .product-white-panel .price-main {
        font-family: 'Oswald', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        color: var(--gun-accent);
        line-height: 1;
        margin-bottom: 30px;
    }
    .product-white-panel .price-main small {
        font-size: 1.5rem;
        font-weight: 500;
        color: #777;
    }

    /* Кнопки дій */
    .btn-action-lg {
        padding: 15px 30px;
        font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 1.1rem;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-cart-lg {
        background-color: var(--gun-accent);
        color: #fff;
        border: none;
        width: 100%;
    }
    .btn-cart-lg:hover {
        background-color: #e65c00;
        box-shadow: 0 10px 20px rgba(230, 92, 0, 0.3);
    }
    .btn-edit-lg {
        background-color: #f3f4f6;
        color: #333;
        border: 1px solid #e5e7eb;
    }
    .btn-edit-lg:hover {
        background-color: #e5e7eb;
    }

    /* --- ПЕРЕБИВАЄМО ТЕМНІ СТИЛІ ОПИСУ (Для нижнього блоку) --- */
    .product-white-panel .gun-description {
        color: #444 !important;
        font-family: 'Roboto', sans-serif;
    }
    .product-white-panel .gun-description h4,
    .product-white-panel .gun-description h5,
    .product-white-panel .gun-description h6,
    .product-white-panel .text-white {
        color: #111 !important;
    }
    .product-white-panel .text-light {
        color: #333 !important;
    }
    .product-white-panel .text-secondary,
    .product-white-panel .text-muted {
        color: #666 !important;
    }
    .product-white-panel .border-bottom,
    .product-white-panel .border-top,
    .product-white-panel .border-secondary {
        border-color: #e5e7eb !important;
    }
    .product-white-panel .gun-description .p-4[style*="background-color: #18181b"] {
        background-color: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        color: #333 !important;
    }
</style>

<div class="container">
    
    {{-- Хлібні крихти --}}
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Головна</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category_id' => $product->category_id]) }}" class="text-muted text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    {{-- ОСНОВНА БІЛА ПАНЕЛЬ ТОВАРУ --}}
    <div class="product-white-panel">
        <div class="row g-5">
            {{-- ЛІВА КОЛОНКА: ФОТО --}}
            <div class="col-lg-6">
                <div class="product-gallery">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="bi bi-camera text-secondary fs-1 opacity-25"></i>
                    @endif
                </div>
            </div>

            {{-- ПРАВА КОЛОНКА: ІНФО --}}
            <div class="col-lg-6">
                <div class="d-flex flex-column h-100 justify-content-center">
                    
                    <h1 class="section-title">{{ $product->name }}</h1>
                    
                    <div class="mb-4">
                        <span class="badge bg-secondary text-uppercase ls-1">{{ $product->category->name }}</span>
                        <span class="badge bg-danger ms-2">Під замовлення</span> {{-- Можна повернути логіку наявності, якщо треба --}}
                    </div>

                    <div class="price-main">
                        {{ number_format($product->price, 0) }} <small>грн</small>
                    </div>

                    {{-- Кнопки --}}
                    <div class="row g-3">
                        <div class="col-12 col-xl-7">
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-cart-lg btn-action-lg d-flex align-items-center justify-content-center">
                                <i class="bi bi-bag-plus-fill me-3 fs-5"></i> ДО КОШИКА
                            </a>
                        </div>
                        
                        {{-- Кнопка "В обране" (Маленька поруч) --}}
                        <div class="col-auto d-flex align-items-center">
                             @auth
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-action-lg px-4" title="В обране" style="border-radius: 12px;">
                                        @if(Auth::user()->wishlist->contains('product_id', $product->id))
                                            <i class="bi bi-heart-fill"></i>
                                        @else
                                            <i class="bi bi-heart"></i>
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>

                        {{-- Кнопка Адміна --}}
                        @if(Auth::check() && Auth::user()->is_admin)
                        <div class="col-12 mt-2">
                             <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit-lg btn-action-lg w-100">
                                <i class="bi bi-pencil me-2"></i> Редагувати товар
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- ТУТ БУВ КОРОТКИЙ ОПИС - ВИДАЛЕНО --}}

                </div>
            </div>
        </div>

        <hr class="my-5" style="border-color: #e5e7eb;">

        {{-- ПОВНИЙ ОПИС (З ПЕРЕБИТИМИ СТИЛЯМИ) --}}
        <div id="full-description">
            {{-- Виводимо опис з бази --}}
            {!! $product->description !!}
        </div>

    </div>
</div>

@endsection