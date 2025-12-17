<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories|max:255']);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Тип озброєння додано.');
    }

    public function edit(Category $category) // Тут важливо: параметр $category, а не $type, бо так працює Resource Binding
    {
        // Оскільки в маршрутах ми використовуємо resource 'types', Laravel шукатиме змінну, що відповідає однині
        // Але ми можемо прийняти ID або модель. Якщо модель Category прив'язана, це працює.
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|max:255']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Тип оновлено.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Тип видалено.');
    }
}