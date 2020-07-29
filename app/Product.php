<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name_ar', 'name_en', 'price', 'category_id', 'image'];
    protected $appends = ['name', 'image_path'];

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;

    }//end of name attribut

    public function getImagePathAttribute()
    {
        return \Storage::url($this->image);

    }//end of image path attribute

    public function category()
    {
        return $this->belongsTo(Category::class);

    }//end fo category

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order');

    }//end of orders

}//end of model
