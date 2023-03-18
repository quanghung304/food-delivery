<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getProductByName($productName)
    {
        return Product::where('name', $productName)->first();
    }

    public function searchProduct($request)
    {
        $data = Product::query();
        if($request->category_id) {
            $data =$data->where('category_id', $request->category_id);
        }

        if($request->name) {
            $data->where('name', 'like', '%' . $request->name . '%');
        }
        return $data;
    }
}
