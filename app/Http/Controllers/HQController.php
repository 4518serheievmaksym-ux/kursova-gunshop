<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class HQController extends Controller
{
    public function index()
    {
        // 1. Статистика (Лічильники)
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        // Рахуємо тільки клієнтів (is_admin = 0)
        $usersCount = User::where('is_admin', 0)->count();

        // 2. Список товарів (з пагінацією)
        $products = Product::with('category')->latest()->paginate(10);

        // 3. Список останніх клієнтів (останні 10 реєстрацій)
        $users = User::where('is_admin', 0)->latest()->take(10)->get();

        return view('admin.index', compact('products', 'users', 'productsCount', 'categoriesCount', 'usersCount'));
    }
}