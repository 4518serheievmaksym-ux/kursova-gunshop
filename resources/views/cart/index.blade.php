@extends('layout')

@section('content')

<style>
    .cart-header {
        background-color: #202023; padding: 20px; border-bottom: 1px solid #333;
        margin-bottom: 30px; border-left: 5px solid var(--gun-accent);
    }
    .cart-title {
        font-family: 'Oswald', sans-serif; color: #fff; margin: 0; text-transform: uppercase; letter-spacing: 2px;
    }

    /* Таблиця кошика */
    .cart-table {
        width: 100%; border-collapse: separate; border-spacing: 0 10px;
    }
    .cart-row {
        background-color: #18181b; transition: 0.3s;
    }
    .cart-row:hover { background-color: #222; transform: translateX(5px); }
    
    .cart-cell { padding: 15px; vertical-align: middle; border-top: 1px solid #333; border-bottom: 1px solid #333; }
    .cart-row td:first-child { border-left: 1px solid #333; border-top-left-radius: 6px; border-bottom-left-radius: 6px; }
    .cart-row td:last-child { border-right: 1px solid #333; border-top-right-radius: 6px; border-bottom-right-radius: 6px; }

    .cart-img {
        width: 70px; height: 70px; background-color: #fff; object-fit: contain; border-radius: 4px; padding: 5px;
    }
    .cart-name {
        color: #fff; font-weight: bold; font-size: 1.1rem; display: block; text-decoration: none;
    }
    .cart-price { color: var(--gun-accent); font-family: 'Oswald', sans-serif; font-size: 1.2rem; }
    
    .btn-remove-cart {
        color: #666; background: none; border: none; font-size: 1.2rem; transition: 0.3s;
    }
    .btn-remove-cart:hover { color: #ef4444; }

    /* Підсумок */
    .cart-summary {
        background-color: #18181b; border: 1px solid #333; padding: 30px; margin-top: 30px; text-align: right;
    }
    .total-label { color: #888; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }
    .total-price { color: #fff; font-family: 'Oswald', sans-serif; font-size: 2.5rem; line-height: 1; margin-bottom: 20px; }
    
    .btn-checkout {
        background-color: var(--gun-accent); color: #000; font-family: 'Oswald', sans-serif; font-weight: bold; text-transform: uppercase;
        padding: 15px 40px; border: none; font-size: 1.2rem; transition: 0.3s; text-decoration: none; display: inline-block;
        clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
    }
    .btn-checkout:hover { background-color: #fff; box-shadow: 0 0 20px rgba(249, 115, 22, 0.5); }
</style>

<div class="container">
    <div class="cart-header">
        <h2 class="cart-title"><i class="bi bi-backpack-fill me-3"></i> Кошик</h2>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="cart-table">
            @foreach(session('cart') as $id => $details)
                <tr class="cart-row">
                    <td class="cart-cell" style="width: 100px;">
                        @if(isset($details['image']))
                            <img src="{{ asset('storage/' . $details['image']) }}" class="cart-img" alt="img">
                        @else
                            <div class="cart-img d-flex align-items-center justify-content-center bg-dark text-muted"><i class="bi bi-box"></i></div>
                        @endif
                    </td>
                    <td class="cart-cell">
                        <a href="{{ route('products.show', $id) }}" class="cart-name">{{ $details['name'] }}</a>
                    </td>
                    <td class="cart-cell text-center text-muted" style="width: 150px;">
                        {{ $details['quantity'] }} шт.
                    </td>
                    <td class="cart-cell text-end" style="width: 150px;">
                        <div class="cart-price">{{ number_format($details['price'] * $details['quantity'], 0) }} ₴</div>
                    </td>
                    <td class="cart-cell text-center" style="width: 60px;">
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf @method('DELETE')
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="btn-remove-cart" title="Видалити"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="cart-summary">
            <div class="total-label">Загальна вартість спорядження</div>
            <div class="total-price">{{ number_format($total, 0) }} ₴</div>
            
            <a href="#" class="btn-checkout">
                <i class="bi bi-credit-card me-2"></i> ОФОРМИТИ ЗАМОВЛЕННЯ
            </a>
        </div>

    @else
        {{-- БЛОК ПОРОЖНЬОГО КОШИКА --}}
        <div class="text-center py-5">
            {{-- Оновлена іконка --}}
            <i class="bi bi-cart-fill text-warning" style="font-size: 5rem; opacity: 0.8;"></i>
            
            <h4 class="text-white mt-4 text-uppercase fw-bold">Список кошика порожній</h4>
            <p class="text-muted">Ви ще не обрали жодного товару.</p>
            <a href="{{ route('products.index') }}" class="btn btn-warning mt-3 text-uppercase fw-bold px-4">Перейти до Арсеналу</a>
        </div>
    @endif
</div>

@endsection