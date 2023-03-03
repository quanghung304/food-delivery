<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function getCategoryByName($categoryName)
    {
        return Category::where('category_name', $categoryName)->first();
    }
}
