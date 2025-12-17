@extends('layout')

@section('content')

<style>
    /* --- СТИЛІ ДОСЬЄ (PROFILE) --- */
    .dossier-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Ліва колонка (Картка особи) */
    .profile-sidebar {
        background: linear-gradient(145deg, #1c1c1f, #111);
        border: 1px solid #333;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .profile-avatar {
        width: 120px; height: 120px;
        margin: 0 auto 20px;
        background-color: #27272a;
        color: var(--gun-accent);
        font-family: 'Oswald', sans-serif;
        font-size: 3.5rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #333;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(249, 115, 22, 0.1);
    }

    .profile-name {
        font-family: 'Oswald', sans-serif;
        font-size: 1.5rem;
        color: #fff;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .profile-rank {
        display: inline-block;
        padding: 4px 12px;
        background-color: #222;
        border: 1px solid #444;
        color: #888;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        border-radius: 4px;
        margin-bottom: 25px;
    }
    .profile-rank.admin { border-color: var(--gun-accent); color: var(--gun-accent); }

    .profile-info-row {
        text-align: left;
        padding: 12px 0;
        border-bottom: 1px solid #333;
        color: #ccc;
        font-size: 0.9rem;
    }
    .profile-info-row:last-child { border-bottom: none; }
    .profile-info-label { color: #666; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; display: block; margin-bottom: 2px; }

    /* Права колонка (Контент) */
    .profile-content-card {
        background-color: #18181b;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .section-header {
        font-family: 'Oswald', sans-serif;
        font-size: 1.2rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #333;
        display: flex; justify-content: space-between; align-items: center;
    }

    /* Статистика (Grid) */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-box {
        background-color: #121214;
        border: 1px solid #333;
        padding: 20px;
        border-radius: 6px;
        text-align: center;
        transition: 0.3s;
    }
    .stat-box:hover { border-color: var(--gun-accent); transform: translateY(-3px); }
    .stat-val { font-family: 'Oswald', sans-serif; font-size: 2rem; color: #fff; line-height: 1; }
    .stat-key { font-size: 0.75rem; color: #666; text-transform: uppercase; font-weight: 700; margin-top: 5px; }

    /* Міні-картки товарів (Схрон) */
    .mini-product-card {
        display: flex;
        align-items: center;
        background-color: #121214;
        border: 1px solid #333;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 6px;
        transition: 0.2s;
        text-decoration: none;
    }
    .mini-product-card:hover { background-color: #222; border-color: #555; }
    .mini-img {
        width: 50px; height: 50px;
        background-color: #fff;
        border-radius: 4px;
        object-fit: contain;
        margin-right: 15px;
    }
    .mini-info { flex-grow: 1; }
    .mini-name { color: #fff; font-weight: 600; font-size: 0.95rem; margin-bottom: 2px; }
    .mini-price { color: var(--gun-accent); font-family: 'Oswald', sans-serif; font-size: 0.9rem; }

    /* Кнопки */
    .btn-profile-action {
        width: 100%;
        padding: 10px;
        background-color: #222;
        border: 1px solid #444;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 10px;
        transition: 0.2s;
    }
    .btn-profile-action:hover { background-color: #333; border-color: #fff; }
    .btn-logout { background-color: rgba(239, 68, 68, 0.1); border-color: #ef4444; color: #ef4444; }
    .btn-logout:hover { background-color: #ef4444; color: #fff; }
</style>

<div class="container dossier-container py-4">
    
    <div class="row g-4">
        
        {{-- ЛІВА КОЛОНКА (ОСОБИСТІ ДАНІ) --}}
        <div class="col-lg-4">
            <div class="profile-sidebar">
                
                {{-- Аватар --}}
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h2 class="profile-name">{{ $user->name }}</h2>
                
                <div class="profile-rank {{ $user->is_admin ? 'admin' : '' }}">
                    {{ $user->is_admin ? 'Адмін' : 'Клієнт' }}
                </div>

                <div class="mt-4 text-start">
                    <div class="profile-info-row">
                        <span class="profile-info-label">Email</span>
                        {{ $user->email }}
                    </div>
                    <div class="profile-info-row">
                        <span class="profile-info-label">Дата реєстрації</span>
                        {{ $user->created_at->format('d.m.Y') }}
                    </div>
                    <div class="profile-info-row">
                        <span class="profile-info-label">ID Користувача</span>
                        UKR-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div class="mt-5">
                    @if($user->is_admin)
                        <a href="{{ route('admin.index') }}" class="btn btn-profile-action" style="border-color: var(--gun-accent); color: var(--gun-accent);">
                            <i class="bi bi-shield-lock me-2"></i> Перейти до Арсеналу
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-profile-action btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i> Вийти з системи
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- ПРАВА КОЛОНКА (СТАТИСТИКА ТА ІСТОРІЯ) --}}
        <div class="col-lg-8">
            
            {{-- 1. БЛОК СТАТИСТИКИ --}}
            <div class="profile-content-card">
                <div class="section-header">Ваш Кабінет</div>
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-val text-warning">{{ $user->wishlist->count() }}</div>
                        <div class="stat-key">В обраному</div>
                    </div>
                    <div class="stat-box">
                        {{-- Заглушка, поки немає ордерів --}}
                        <div class="stat-val">0</div>
                        <div class="stat-key">Замовлень</div>
                    </div>
                </div>
            </div>

            {{-- 2. ОСТАННІ В СХРОНІ --}}
            <div class="profile-content-card">
                <div class="section-header">
                    <span><i class="bi bi-heart-fill text-danger me-2"></i> Нещодавно збережені</span>
                    <a href="{{ route('wishlist.index') }}" class="text-decoration-none text-muted small" style="font-size: 0.8rem;">Всі &rarr;</a>
                </div>

                @forelse($wishlistItems as $item)
                    <a href="{{ route('products.show', $item->product->id) }}" class="mini-product-card">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="mini-img" alt="img">
                        @else
                            <div class="mini-img d-flex align-items-center justify-content-center bg-dark text-muted">
                                <i class="bi bi-crosshair"></i>
                            </div>
                        @endif
                        
                        <div class="mini-info">
                            <div class="mini-name">{{ $item->product->name }}</div>
                            <div class="text-muted small">{{ $item->product->category->name }}</div>
                        </div>
                        
                        <div class="mini-price">{{ number_format($item->product->price, 0) }} ₴</div>
                    </a>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Кошик порожній
                    </div>
                @endforelse
            </div>

            {{-- 3. ІСТОРІЯ ЗАМОВЛЕНЬ (ЗАГЛУШКА) --}}
            <div class="profile-content-card">
                <div class="section-header">Історія поставок</div>
                <div class="text-center py-4 text-muted border border-secondary border-dashed" style="border-style: dashed; background: rgba(255,255,255,0.02);">
                    <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-50"></i>
                    Активних замовлень не знайдено.
                    <br>
                    <a href="{{ route('products.index') }}" class="text-warning text-decoration-none mt-2 d-inline-block">Перейти до Арсеналу</a>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection