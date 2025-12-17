@extends('layout')

@section('content')

<style>
    :root {
        --gun-bg: #0f0f10;
        --gun-surface: #18181b;
        --gun-border: #27272a;
        --gun-accent: #f97316; /* Помаранчевий */
    }

    /* --- ЗАГОЛОВОК --- */
    .section-title {
        font-family: 'Oswald', sans-serif;
        font-size: 2.5rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    .section-title::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 60px; height: 4px; background-color: var(--gun-accent);
    }

    /* --- ФІЛЬТРИ --- */
    .filter-panel {
        background: linear-gradient(145deg, #1c1c1f, #111);
        border: 1px solid #333; padding: 25px; margin-bottom: 50px; position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .filter-panel::before { content: ''; position: absolute; top: -1px; left: -1px; width: 20px; height: 20px; border-top: 3px solid var(--gun-accent); border-left: 3px solid var(--gun-accent); }
    .filter-panel::after { content: ''; position: absolute; bottom: -1px; right: -1px; width: 20px; height: 20px; border-bottom: 3px solid var(--gun-accent); border-right: 3px solid var(--gun-accent); }

    .filter-label { color: var(--gun-accent); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: bold; margin-bottom: 8px; display: block; font-family: 'Oswald', sans-serif; }
    
    .form-control-gun, .form-select-gun {
        background-color: #0a0a0a; border: 1px solid #333; color: #fff; border-radius: 0; padding: 12px; font-family: 'Roboto', sans-serif; transition: 0.3s;
    }
    .form-control-gun:focus, .form-select-gun:focus { background-color: #000; border-color: var(--gun-accent); box-shadow: 0 0 15px rgba(249, 115, 22, 0.1); }

    .btn-filter {
        background-color: var(--gun-accent); color: #000; border: none; border-radius: 0; font-weight: 800; width: 100%; padding: 12px;
        text-transform: uppercase; font-family: 'Oswald', sans-serif; letter-spacing: 1px; transition: 0.3s;
        clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
    }
    .btn-filter:hover { background-color: #fff; color: #000; box-shadow: 0 0 20px rgba(249, 115, 22, 0.6); }

    /* --- КАРТКА ТОВАРУ --- */
    .weapon-card {
        background-color: var(--gun-surface); border: 1px solid var(--gun-border); transition: 0.3s; height: 100%; position: relative; display: flex; flex-direction: column; overflow: hidden;
    }
    .weapon-card:hover { border-color: var(--gun-accent); transform: translateY(-7px); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6); }

    .card-img-wrapper {
        height: 240px; background-color: #fff; display: flex; align-items: center; justify-content: center; padding: 20px; position: relative;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 85% 100%, 0 100%); margin-bottom: -15px; z-index: 1;
    }
    .card-img-wrapper img { max-height: 100%; max-width: 100%; object-fit: contain; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3)); transition: transform 0.4s ease; }
    .weapon-card:hover .card-img-wrapper img { transform: scale(1.08) rotate(-2deg); }

    /* Посилання на товар (замість stretched-link) */
    .product-link { display: block; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }

    .weapon-cat {
        position: absolute; top: 0; left: 0; background: var(--gun-accent); color: #000; padding: 5px 12px; font-size: 0.75rem;
        text-transform: uppercase; font-weight: 800; font-family: 'Oswald', sans-serif; z-index: 2; pointer-events: none;
    }

    /* --- АДМІН ОВЕРЛЕЙ (Виправлено) --- */
    .admin-overlay {
        position: absolute; 
        top: 10px; 
        right: 10px; 
        z-index: 100; /* Найвищий пріоритет */
        display: flex;
        gap: 5px;
    }
    .btn-admin-overlay {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px); color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 4px; transition: 0.2s; text-decoration: none;
        cursor: pointer;
    }
    .btn-admin-overlay.edit:hover { background-color: #eab308; border-color: #eab308; color: #000; box-shadow: 0 0 10px rgba(234, 179, 8, 0.8); }
    .btn-admin-overlay.del:hover { background-color: #ef4444; border-color: #ef4444; color: #fff; box-shadow: 0 0 10px rgba(239, 68, 68, 0.8); }

    /* ІНФО БЛОК */
    .card-info {
        padding: 25px 20px 20px; background: linear-gradient(180deg, #1f1f23 0%, #18181b 100%); flex-grow: 1; display: flex; flex-direction: column; border-top: 1px solid #333;
    }

    .weapon-title {
        font-family: 'Oswald', sans-serif; font-size: 1.35rem; color: #fff; text-decoration: none; display: block; margin-bottom: auto; line-height: 1.2; transition: 0.2s;
    }
    .weapon-title:hover { color: var(--gun-accent); }

    .card-footer-custom {
        display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #333; padding-top: 20px; margin-top: 20px;
    }

    .price-tag { font-family: 'Oswald', sans-serif; font-size: 1.6rem; color: #fff; font-weight: bold; }
    .price-tag small { font-size: 0.9rem; color: #666; font-weight: normal; }

    /* КНОПКИ КЛІЄНТА */
    .btn-icon {
        width: 42px; height: 42px; border: 1px solid #444; background: transparent; color: #fff; display: flex; align-items: center; justify-content: center; transition: 0.3s; border-radius: 0;
        z-index: 50; position: relative;
    }
    .btn-icon:hover { border-color: #fff; color: #fff; }
    .btn-icon.is-favorite { border-color: #ef4444; color: #ef4444; }
    .btn-icon.is-favorite:hover { background-color: #ef4444; color: #fff; }

    .btn-cart-premium {
        width: 42px; height: 42px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border: none; border-radius: 6px; color: #000;
        display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.4); transition: all 0.3s ease;
        z-index: 50; position: relative;
    }
    .btn-cart-premium:hover { background: linear-gradient(135deg, #fb923c 0%, #f97316 100%); color: #fff; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(234, 88, 12, 0.6); }
</style>

<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h2 class="section-title">АРСЕНАЛ</h2>
    </div>
    <div class="col-md-6 text-md-end">
        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('products.create') }}" class="btn btn-outline-light rounded-0 text-uppercase fw-bold px-4 py-2">
                <i class="bi bi-plus-lg me-2"></i>Додати товар
            </a>
        @endif
    </div>
</div>

<div class="filter-panel">
    <form action="{{ route('products.index') }}" method="GET">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="row g-4 align-items-end">
            <div class="col-md-3">
                <label class="filter-label">ТИП ОЗБРОЄННЯ</label>
                <select name="category_id" class="form-select form-select-gun">
                    <option value="">Всі категорії</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="filter-label">БЮДЖЕТ (ВІД)</label>
                <input type="number" name="min_price" class="form-control form-control-gun" placeholder="0" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-3">
                <label class="filter-label">БЮДЖЕТ (ДО)</label>
                <input type="number" name="max_price" class="form-control form-control-gun" placeholder="100000" value="{{ request('max_price') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-filter">
                    <i class="bi bi-crosshair me-2"></i> ЗАСТОСУВАТИ
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row g-4">
    @foreach($products as $product)
    <div class="col-md-4 col-lg-3">
        <div class="weapon-card">
            
            <div class="card-img-wrapper">
                <span class="weapon-cat">{{ $product->category ? $product->category->name : 'ЕКІПІРОВКА' }}</span>
                
                {{-- АДМІНСЬКІ КНОПКИ (ПОВЕРХ ФОТО, ПРАЦЮЮТЬ!) --}}
                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="admin-overlay">
                        {{-- Редагувати --}}
                        <a href="{{ route('products.edit', $product->id) }}" class="btn-admin-overlay edit" title="Редагувати">
                            <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                        </a>
                        
                        {{-- Видалити --}}
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-admin-overlay del" title="Видалити" onclick="return confirm('Списати цей товар?')">
                                <i class="bi bi-trash-fill" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Посилання на товар (Тільки на фото) --}}
                <a href="{{ route('products.show', $product->id) }}" class="product-link">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="bi bi-crosshair text-secondary" style="font-size: 4rem;"></i>
                    @endif
                </a>
            </div>

            <div class="card-info">
                {{-- Посилання на товар (Тільки на назву) --}}
                <h5 class="weapon-title">
                    <a href="{{ route('products.show', $product->id) }}" class="text-white text-decoration-none">
                        {{ $product->name }}
                    </a>
                </h5>
                
                <div class="card-footer-custom">
                    <div class="price-tag">{{ number_format($product->price, 0) }} <small>₴</small></div>
                    
                    {{-- КНОПКИ КЛІЄНТА --}}
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-icon {{ Auth::user()->wishlist->contains('product_id', $product->id) ? 'is-favorite' : '' }}" title="В обране">
                                    <i class="bi {{ Auth::user()->wishlist->contains('product_id', $product->id) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-icon" title="В обране">
                                <i class="bi bi-heart"></i>
                            </a>
                        @endauth

                        <a href="{{ route('cart.add', $product->id) }}" class="btn-cart-premium" title="Додати в кошик">
                            <i class="bi bi-cart-fill fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-5 mb-5">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

@endsection