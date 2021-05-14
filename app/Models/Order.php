<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable=['user_id','order_number','sub_total','quantity','status','total_amount','first_name','last_name','country','address','phone','email','payment_method','payment_status','coupon'];
}
