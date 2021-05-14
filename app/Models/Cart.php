<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable=['user_id','product_id','order_id','quantity','amount','price'];
    //Định nghĩa mối quan hệ với table products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    //Định nghĩa mối quan hệ với table orders
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
