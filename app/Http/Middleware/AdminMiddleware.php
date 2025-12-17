<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        // Перевіряємо: якщо користувач залогінений І він адмін (is_admin == 1)
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request); // Пропускаємо далі
        }

        // Якщо ні — показуємо помилку 403 (Заборонено) або кидаємо на головну
        abort(403, 'Доступ заборонено.');
    }
}
