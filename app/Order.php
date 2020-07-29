<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'total_price',
        'status', 'note'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    }//end of products

    public function getStatusAttribute($value)
    {
        return __('site.order_status.' . $value);

    }//end of get status attribute
}//end of model
