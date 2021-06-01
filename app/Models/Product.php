<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'description', 'cat_id', 'price', 'discount', 'status', 'photo', 'weight', 'stock', 'is_featured', 'condition', 'manufacturer', 'expiry'];
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
    public static function getProductBySlug($slug)
    {
        return Product::with(['cat_info', 'rel_prods', 'getReview'])->where('slug', $slug)->first();
    }
    public function rel_prods()
    {
        return $this->hasMany('App\Models\Product', 'cat_id', 'cat_id')->where('status', 'active')->orderBy('id', 'DESC')->limit(8);
    }
    public function review()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }
    public function comment(){
        return $this->hasMany(ProductComment::class,'product_id','id');
    }
}
