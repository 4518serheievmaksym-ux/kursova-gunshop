<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Дозволяємо редагувати поле 'name'
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}