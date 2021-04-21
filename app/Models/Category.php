<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title','slug','summary','photo','status'];
    //Lấy danh sách sản phẩm trong category
    public function products(){
        return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');
    }
    //Tìm sản phẩm trong category
    public static function getProductByCat($slug){
        // dd($slug);
        return Category::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    //Đếm số category đang active
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
