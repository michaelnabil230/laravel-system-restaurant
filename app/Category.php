<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'position'
    ];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;

    }//end of name attribute

    public function products()
    {
        return $this->hasMany(Product::class);

    }//end of products

    public function saveQuietly()
    {
        return static::withoutEvents(function () {
            return $this->save();
        });
    }
}//end of model
