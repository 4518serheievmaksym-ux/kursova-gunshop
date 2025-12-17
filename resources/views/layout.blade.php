<!doctype html>
<html lang="uk" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GunShop - Tactical Arsenal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gun-bg: #0f0f10;
            --gun-surface: #18181b;
            --gun-border: #27272a;
            --gun-accent: #f97316;
            --gun-text: #e4e4e7;
        }

        body {
            background-color: var(--gun-bg);
            color: var(--gun-text);
            font-family: 'Roboto', sans-serif;
            padding-top: 85px;
        }

        /* --- NAVBAR --- */
        .navbar-gun {
            background-color: rgba(15, 15, 16, 0.95);
            border-bottom: 1px solid var(--gun-border);
            backdrop-filter: blur(10px);
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .brand-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-text {
            font-family: 'Roboto', sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1;
        }
        .brand-accent { color: var(--gun-accent); }

        /* Посилання меню */
        .nav-item-gun .nav-link {
            color: #a1a1aa !important;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.95rem;
            transition: 0.3s;
            position: relative;
        }
        .nav-item-gun .nav-link:hover, .nav-item-gun .nav-link.active {
            color: #fff !important;
        }
        .nav-item-gun .nav-link::after {
            content: ''; position: absolute; width: 0; height: 2px; bottom: -5px; left: 0;
            background-color: var(--gun-accent); transition: width 0.3s;
        }
        .nav-item-gun .nav-link:hover::after { width: 100%; }

        /* Адмін-посилання в меню */
        .nav-item-gun .nav-link.admin-link {
            color: var(--gun-accent) !important; /* Завжди помаранчеве */
            font-weight: 700;
        }
        .nav-item-gun .nav-link.admin-link:hover {
            color: #fff !important;
            text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
        }

        .header-search { position: relative; }
        .search-input {
            background-color: #18181b; border: 1px solid #333; color: #fff; border-radius: 8px;
            padding: 8px 15px; padding-right: 40px; width: 250px; transition: 0.3s; font-size: 0.9rem;
        }
        .search-input:focus {
            background-color: #000; border-color: var(--gun-accent);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15); width: 300px;
        }
        .search-btn {
            position: absolute; right: 5px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #666; transition: 0.3s;
        }
        .search-btn:hover { color: var(--gun-accent); }

        .header-icon {
            position: relative; color: #fff; font-size: 1.3rem; margin-left: 20px;
            transition: 0.3s; display: flex; align-items: center; text-decoration: none;
        }
        .header-icon:hover { color: var(--gun-accent); transform: translateY(-2px); }
        
        .badge-count {
            position: absolute; top: -6px; right: -8px; background-color: var(--gun-accent);
            color: #000; font-size: 0.6rem; font-weight: 800; padding: 2px 5px; border-radius: 6px;
        }

        .btn-login {
            color: #fff; font-weight: 600; font-size: 0.9rem; text-decoration: none;
            transition: 0.3s; margin-left: 20px;
        }
        .btn-login:hover { color: var(--gun-accent); }

        .btn-register {
            background-color: var(--gun-accent); color: #000; font-weight: 700; font-size: 0.9rem;
            padding: 8px 20px; border-radius: 8px; text-decoration: none; transition: 0.3s; margin-left: 15px;
        }
        .btn-register:hover { background-color: #fff; box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4); }

        .dropdown-menu-dark {
            background-color: #18181b; border: 1px solid #333; border-radius: 8px; margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .dropdown-item { color: #ccc; padding: 8px 20px; transition: 0.2s; font-weight: 500; }
        .dropdown-item:hover { background-color: #27272a; color: var(--gun-accent); }
        .dropdown-divider { border-color: #333; }
        
        .user-name-link {
            text-decoration: none; color: #fff; font-weight: 600; font-size: 1rem; transition: 0.3s;
        }
        .user-name-link:hover { color: var(--gun-accent); }

        /* Pagination Styles */
        .gun-pagination-nav { margin-top: 40px; margin-bottom: 40px; }
        .pagination-gun .page-link {
            background-color: var(--gun-surface); border: 1px solid var(--gun-border); color: #a1a1aa;
            border-radius: 0 !important; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-family: 'Oswald', sans-serif; font-size: 1.1rem; margin: 0 3px; transition: all 0.2s ease;
        }
        .pagination-gun .page-link:hover {
            background-color: #333; color: var(--gun-accent); border-color: var(--gun-accent);
            transform: translateY(-2px); z-index: 2;
        }
        .pagination-gun .page-item.active .page-link {
            background-color: var(--gun-accent); color: #000; border-color: var(--gun-accent);
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.4);
        }
        .pagination-gun .page-item.disabled .page-link {
            background-color: transparent; color: #333; border-color: #222; cursor: default;
        }
        .pagination-gun .page-link:focus { box-shadow: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-gun fixed-top">
  <div class="container">
    
    <a class="brand-link" href="{{ route('products.index') }}">
        <i class="bi bi-crosshair fs-3 text-white"></i>
        <span class="brand-text">GUN<span class="brand-accent">SHOP</span></span>
    </a>
    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <i class="bi bi-list text-white fs-2"></i>
    </button>
    
    <div class="collapse navbar-collapse" id="navMain">
      
      <ul class="navbar-nav me-auto ms-4 mb-2 mb-lg-0 align-items-center">
        {{-- Звичайне меню --}}
        <li class="nav-item nav-item-gun">
            <a class="nav-link active" href="{{ route('products.index') }}">Арсенал</a>
        </li>

        {{-- АДМІН-ПАНЕЛЬ (Тільки для адміна) --}}
        @auth
            @if(Auth::user()->is_admin)
                <li class="nav-item nav-item-gun ms-3">
                    <a class="nav-link admin-link" href="{{ route('admin.index') }}">
                        <i class="bi bi-shield-lock-fill me-1"></i>Адмін-панель
                    </a>
                </li>
            @endif
        @endauth
      </ul>
      
      <form class="header-search d-flex me-4" action="{{ route('products.index') }}" method="GET">
        <input class="search-input" type="search" name="search" placeholder="Пошук..." value="{{ request('search') }}">
        <button class="search-btn" type="submit"><i class="bi bi-search"></i></button>
      </form>

      <div class="d-flex align-items-center">
        
        {{-- СХРОН (З лічильником) --}}
        <a href="{{ route('wishlist.index') }}" class="header-icon" title="Схрон">
            <i class="bi bi-heart-fill"></i>
            @auth
                @if(Auth::user()->wishlist()->count() > 0)
                    <span class="badge-count">{{ Auth::user()->wishlist()->count() }}</span>
                @endif
            @endauth
        </a>

        {{-- КОШИК (З лічильником) --}}
        <a href="{{ route('cart.index') }}" class="header-icon me-3" title="Екіпіровка">
            <i class="bi bi-cart-fill"></i>
            @if(session('cart') && count(session('cart')) > 0)
                <span class="badge-count">{{ count(session('cart')) }}</span>
            @endif
        </a>

        @guest
            <a href="{{ route('login') }}" class="btn-login">Вхід</a>
            <a href="{{ route('register') }}" class="btn-register">Реєстрація</a>
        @else
            <div class="dropdown ms-2">
                <a class="user-name-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>
                
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>Профіль</a></li>
                    
                    {{-- Дубль посилання в меню (на всякий випадок) --}}
                    @if(Auth::user()->is_admin)
                        <li><a class="dropdown-item text-warning" href="{{ route('admin.index') }}"><i class="bi bi-shield-lock me-2"></i>ADMIN</a></li>
                    @endif
                    
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Вийти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        @endguest

      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>