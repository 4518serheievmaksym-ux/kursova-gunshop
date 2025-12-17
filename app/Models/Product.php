<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Дозволяємо редагувати ці поля
    protected $fillable = [
        'category_id', 
        'name', 
        'price', 
        'description', 
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}