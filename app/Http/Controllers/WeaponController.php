<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Важливо для видалення фото
use App\Models\Product;
use App\Models\Category;

class WeaponController extends Controller
{
    /**
     * ==========================================
     * ПУБЛІЧНА ЧАСТИНА (КАТАЛОГ)
     * ==========================================
     */

    /**
     * Головна сторінка каталогу (Арсенал)
     */
    public function index(Request $request)
    {
        // 1. Починаємо запит до бази (з категоріями для оптимізації)
        $query = Product::with('category');

        // 2. Логіка ПОШУКУ (по назві або опису)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // 3. ФІЛЬТР за категорією
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. ФІЛЬТР за ціною
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 5. ОТРИМУЄМО РЕЗУЛЬТАТ
        // latest() - нові зверху
        // paginate(8) - по 8 карток на сторінку (як домовлялися)
        $products = $query->latest()->paginate(8)->withQueryString();
        
        // Список категорій для випадаючого списку у фільтрі
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Сторінка одного товару (Детальний огляд)
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * ==========================================
     * АДМІН-ЧАСТИНА (УПРАВЛІННЯ)
     * ==========================================
     */
    
    /**
     * Відкрити форму створення товару
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Зберегти новий товар у базу
     */
    public function store(Request $request)
    {
        // 1. Валідація даних
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120' // Макс 5МБ
        ]);

        $input = $request->all();
        
        // 2. Завантаження фото (якщо завантажено)
        if ($request->hasFile('image')) {
            // Зберігає файл у папку storage/app/public/products
            // Повертає шлях, наприклад: "products/filename.jpg"
            $path = $request->file('image')->store('products', 'public');
            $input['image'] = $path;
        }
        
        Product::create($input);
        
        // Повертаємось у "Штаб" (Адмінку)
        return redirect()->route('admin.index')->with('success', 'Нову одиницю додано до арсеналу.');
    }

    /**
     * Відкрити форму редагування товару
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Оновити дані товару
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $input = $request->all();
        
        // Логіка заміни фото
        if ($request->hasFile('image')) {
            // 1. Видаляємо старе фото з диска, якщо воно було
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // 2. Завантажуємо нове
            $path = $request->file('image')->store('products', 'public');
            $input['image'] = $path;
        }
        
        $product->update($input);
        
        return redirect()->route('admin.index')->with('success', 'Дані про одиницю оновлено.');
    }

    /**
     * Видалити товар
     */
    public function destroy(Product $product)
    {
        // 1. Видаляємо фото з диска, щоб не займало місце
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Видаляємо запис з бази
        $product->delete();
        
        return back()->with('success', 'Одиницю списано зі складу.');
    }
}