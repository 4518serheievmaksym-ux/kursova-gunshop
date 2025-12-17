@extends('layout')

@section('content')

<style>
    /* --- АДМІНСЬКИЙ СТИЛЬ --- */
    .admin-header-row {
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #333;
    }
    
    .admin-title {
        font-family: 'Roboto', sans-serif;
        font-weight: 900;
        font-size: 2rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Картки статистики */
    .stat-box {
        background-color: #18181b;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: 0.3s;
    }
    .stat-box:hover {
        border-color: var(--gun-accent);
        transform: translateY(-3px);
    }
    .stat-info h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        color: #fff;
        font-family: 'Oswald', sans-serif;
    }
    .stat-info p {
        margin: 0;
        color: #888;
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: 600;
    }
    .stat-icon-box {
        width: 60px; height: 60px;
        background-color: #222;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: var(--gun-accent);
        font-size: 1.8rem;
    }

    /* Секції та Таблиці */
    .panel-section {
        background-color: #18181b;
        border: 1px solid #333;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 40px;
    }
    .panel-header {
        background-color: #202023;
        padding: 15px 25px;
        border-bottom: 1px solid #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .panel-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
    }

    /* Таблиця */
    .table-admin {
        width: 100%;
        margin-bottom: 0;
        color: #ccc;
        font-size: 0.95rem;
    }
    .table-admin th {
        background-color: #121214;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 15px 25px;
        border-bottom: 1px solid #333;
    }
    .table-admin td {
        padding: 15px 25px;
        border-bottom: 1px solid #27272a;
        vertical-align: middle;
    }
    .table-admin tr:last-child td { border-bottom: none; }
    .table-admin tr:hover td {
        background-color: #1f1f22;
        color: #fff;
    }

    /* Кнопки */
    .btn-action-sm {
        width: 34px; height: 34px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #444; border-radius: 6px;
        color: #bbb; background: transparent; transition: 0.2s;
    }
    .btn-action-sm:hover {
        border-color: var(--gun-accent); color: var(--gun-accent); background: #222;
    }
    .btn-del:hover {
        border-color: #ef4444; color: #ef4444;
    }

    .user-avatar-sm {
        width: 35px; height: 35px;
        background-color: #333; color: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.9rem;
    }
</style>

{{-- ЗАГОЛОВОК СТОРІНКИ --}}
<div class="row admin-header-row align-items-center">
    <div class="col-md-6">
        <h1 class="admin-title">Адмін-панель</h1>
        <p class="text-muted mb-0">Управління магазином та користувачами</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('categories.index') }}" class="btn btn-outline-light me-2">
            <i class="bi bi-list-ul me-2"></i>Категорії
        </a>
        <a href="{{ route('products.create') }}" class="btn btn-warning fw-bold text-dark">
            <i class="bi bi-plus-lg me-2"></i>Додати товар
        </a>
    </div>
</div>

{{-- ПОВІДОМЛЕННЯ --}}
@if(session('success'))
    <div class="alert alert-success bg-dark text-success border-success mb-4">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

{{-- 1. СТАТИСТИКА (БЛОКИ) --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-info">
                <h3>{{ $productsCount }}</h3>
                <p>Товарів</p>
            </div>
            <div class="stat-icon-box">
                <i class="bi bi-box-seam"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-info">
                <h3>{{ $usersCount }}</h3>
                <p>Користувачів</p>
            </div>
            <div class="stat-icon-box">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-info">
                <h3>{{ $categoriesCount }}</h3>
                <p>Категорій</p>
            </div>
            <div class="stat-icon-box">
                <i class="bi bi-tags"></i>
            </div>
        </div>
    </div>
</div>

{{-- 2. ТАБЛИЦЯ ТОВАРІВ (БЕЗ ФОТО) --}}
<div class="panel-section">
    <div class="panel-header">
        <h5 class="panel-title">Останні товари</h5>
        <a href="{{ route('products.create') }}" class="text-decoration-none text-muted small hover-accent">Додати новий &rarr;</a>
    </div>
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Назва товару</th>
                    <th>Категорія</th>
                    <th>Ціна</th>
                    <th class="text-end">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td class="text-muted">#{{ $product->id }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="text-white text-decoration-none fw-bold">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-dark border border-secondary text-secondary">
                            {{ $product->category ? $product->category->name : 'Без категорії' }}
                        </span>
                    </td>
                    <td class="text-warning fw-bold">{{ number_format($product->price, 0) }} ₴</td>
                    <td class="text-end">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn-action-sm me-1" title="Редагувати">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-action-sm btn-del" onclick="return confirm('Видалити цей товар?')" title="Видалити">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Пагінація --}}
    @if($products->hasPages())
        <div class="p-3 border-top border-secondary d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- 3. ТАБЛИЦЯ КОРИСТУВАЧІВ --}}
<div class="panel-section">
    <div class="panel-header">
        <h5 class="panel-title">Останні зареєстровані акаунти</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr>
                    <th style="width: 60px;">Avatar</th>
                    <th>Ім'я</th>
                    <th>Email</th>
                    <th>Дата реєстрації</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="user-avatar-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="fw-bold text-white">{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td class="text-muted small">
                        {{ $user->created_at->format('d.m.Y H:i') }}
                    </td>
                </tr>
                @endforeach
                
                @if($users->isEmpty())
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        Нових користувачів поки немає.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection