@extends('layout')

@section('content')

<style>
    /* Ті самі стилі, що і для логіна, щоб не дублювати код у layout, пропишемо їх тут */
    .auth-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .auth-card {
        background: linear-gradient(145deg, #1c1c1f, #111);
        border: 1px solid #333;
        width: 100%;
        max-width: 500px; /* Трохи ширше для реєстрації */
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .auth-card::before {
        content: ''; position: absolute; top: -1px; left: -1px; width: 30px; height: 30px;
        border-top: 3px solid var(--gun-accent); border-left: 3px solid var(--gun-accent);
    }
    .auth-card::after {
        content: ''; position: absolute; bottom: -1px; right: -1px; width: 30px; height: 30px;
        border-bottom: 3px solid var(--gun-accent); border-right: 3px solid var(--gun-accent);
    }

    .auth-header {
        background-color: rgba(0,0,0,0.3);
        padding: 20px;
        border-bottom: 1px solid #333;
        text-align: center;
    }

    .auth-title {
        font-family: 'Oswald', sans-serif;
        font-size: 1.8rem;
        color: #fff;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .auth-body { padding: 30px; }

    .form-label {
        color: #a1a1aa;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .form-control-auth {
        background-color: #0a0a0a;
        border: 1px solid #333;
        color: #fff;
        border-radius: 0;
        padding: 12px;
        font-size: 1rem;
        transition: 0.3s;
    }
    
    .form-control-auth:focus {
        background-color: #000;
        border-color: var(--gun-accent);
        color: #fff;
        box-shadow: 0 0 15px rgba(249, 115, 22, 0.15);
    }

    .btn-auth {
        background-color: var(--gun-accent);
        color: #000;
        font-family: 'Oswald', sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px;
        border: none;
        border-radius: 0;
        width: 100%;
        transition: 0.3s;
        font-size: 1.1rem;
    }
    .btn-auth:hover {
        background-color: #fff;
        box-shadow: 0 0 20px rgba(249, 115, 22, 0.5);
    }
</style>

<div class="container auth-container">
    <div class="auth-card">
        
        <div class="auth-header">
            <h3 class="auth-title">
                <i class="bi bi-person-plus-fill me-2 text-warning"></i> Реєстрація 
            </h3>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Ім'я --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Ім'я</label>
                    <input id="name" type="text" class="form-control form-control-auth @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Введіть ім'я">
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email адреса</label>
                    <input id="email" type="email" class="form-control form-control-auth @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Пароль --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input id="password" type="password" class="form-control form-control-auth @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Мінімум 8 символів">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Підтвердження --}}
                <div class="mb-4">
                    <label for="password-confirm" class="form-label">Підтвердження пароля</label>
                    <input id="password-confirm" type="password" class="form-control form-control-auth" name="password_confirmation" required autocomplete="new-password" placeholder="Повторіть пароль">
                </div>

                <button type="submit" class="btn btn-auth">
                    СТВОРИТИ АКАУНТ
                </button>

                <div class="text-center mt-4 border-top border-secondary pt-3">
                    <span class="text-muted small">Вже є акаунт?</span>
                    <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold ms-1">ВХІД</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection