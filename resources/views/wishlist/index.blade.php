@extends('layout')

@section('content')

<style>
    .stash-header {
        border-bottom: 1px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .stash-title {
        font-family: 'Oswald', sans-serif;
        font-size: 2rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    /* Картка в схроні */
    .stash-card {
        background-color: #18181b;
        border: 1px solid #333;
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 15px;
        transition: 0.3s;
    }
    .stash-card:hover {
        border-color: var(--gun-accent);
        background-color: #202023;
    }
    
    .stash-img {
        width: 100px; height: 80px;
        background-color: #fff;
        object-fit: contain;
        border-radius: 4px;
        margin-right: 20px;
    }
    
    .stash-info { flex-grow: 1; }
    .stash-name {
        font-family: 'Oswald', sans-serif;
        font-size: 1.2rem;
        color: #fff;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .stash-name:hover { color: var(--gun-accent); }
    
    .stash-price {
        font-weight: bold;
        color: var(--gun-accent);
        font-size: 1.1rem;
    }
    
    .btn-remove-stash {
        background: transparent; border: 1px solid #444; color: #666;
        width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;
        transition: 0.3s;
    }
    .btn-remove-stash:hover { border-color: #ef4444; color: #ef4444; }
    
    .btn-to-cart {
        background-color: var(--gun-accent); color: #000; border: none;
        padding: 8px 20px; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;
        text-decoration: none; transition: 0.3s; margin-right: 10px;
        font-family: 'Oswald', sans-serif;
    }
    .btn-to-cart:hover { background-color: #fff; }
</style>

<div class="container">
    <div class="stash-header d-flex justify-content-between align-items-center">
        <h2 class="stash-title"><i class="bi bi-heart-fill text-danger me-3"></i> Обране</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-light rounded-0 text-uppercase">Арсенал</a>
    </div>

    @forelse($wishlistItems as $item)
        <div class="stash-card">
            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : '' }}" class="stash-img" alt="img">
            
            <div class="stash-info">
                <a href="{{ route('products.show', $item->product->id) }}" class="stash-name">{{ $item->product->name }}</a>
                <div class="text-muted small mb-1">{{ $item->product->category->name }}</div>
                <div class="stash-price">{{ number_format($item->product->price, 0) }} ₴</div>
            </div>

            <div class="d-flex align-items-center">
                <a href="{{ route('cart.add', $item->product->id) }}" class="btn-to-cart">
                    <i class="bi bi-cart-plus me-1"></i> До кошика
                </a>
                
                <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-remove-stash" title="Прибрати">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-heartbreak text-secondary" style="font-size: 4rem;"></i>
            <h4 class="text-white mt-3 text-uppercase">Список обраного порожній</h4>
            <p class="text-muted">Ви ще нічого не відклали на майбутнє.</p>
            <a href="{{ route('products.index') }}" class="btn btn-warning mt-3 text-uppercase fw-bold">Знайти спорядження</a>
        </div>
    @endforelse
</div>
@endsection