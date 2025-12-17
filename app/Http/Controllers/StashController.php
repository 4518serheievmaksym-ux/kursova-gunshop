<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class StashController extends Controller
{
    public function index()
    {
        // Отримуємо товари користувача зі схрону
        $wishlistItems = Auth::user()->wishlist()->with('product')->latest()->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle($productId)
    {
        $user = Auth::user();
        
        // Перевіряємо, чи є вже цей товар у списку
        $exists = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($exists) {
            $exists->delete();
            // Якщо запит прийшов з AJAX (можна додати логіку), або просто редірект
            return back()->with('success', 'Товар прибрано зі схрону.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            return back()->with('success', 'Товар додано до схрону.');
        }
    }
}