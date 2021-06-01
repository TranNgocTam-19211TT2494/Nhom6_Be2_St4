<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $fillable = ['user_id', 'product_id', 'comment', 'replied_comment', 'parent_id', 'status'];

    public function user_info()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public static function getAllComments()
    {
        return ProductComment::with('user_info')->orderBy('created_at', 'DESC')->get();
    }

    public static function getAllUserComments()
    {
        return ProductComment::where('user_id', auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(ProductComment::class, 'parent_id')->where('status', 'active');
    }
}
