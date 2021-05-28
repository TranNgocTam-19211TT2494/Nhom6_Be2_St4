<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['user_id', 'order_number', 'sub_total', 'quantity', 'status', 'total_amount', 'first_name', 'last_name', 'country', 'address', 'phone', 'email', 'payment_method', 'payment_status', 'coupon', 'shipping'];
    //Function
    public function cart_info()
    {
        return $this->hasMany('App\Models\Cart', 'order_id', 'id');
    }
    public static function getAllOrder($id)
    {
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder()
    {
        $data = Order::count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
