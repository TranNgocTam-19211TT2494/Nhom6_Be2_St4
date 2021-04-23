<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";
    protected $fillable = ['title', 'slug', 'summary', 'description', 'cat_id', 'price', 'discount', 'status', 'photo', 'weight', 'stock', 'is_featured', 'condition'];
    //Đếm số sản phẩm đang active trong db
    public static function countActiveProduct()
    {
        $data = Product::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    //Định nghĩa cat_info để lấy thông tin category của product
    public function cat_info()
    {
        //Quan hệ N - 1
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }
}
