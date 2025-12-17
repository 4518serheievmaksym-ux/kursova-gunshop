<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DossierController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Отримуємо товари зі схрону (Wishlist)
        // (Припускаємо, що зв'язок налаштований як hasMany -> product)
        $wishlistItems = $user->wishlist()->with('product')->take(4)->get();

        return view('profile.index', compact('user', 'wishlistItems'));
    }
}