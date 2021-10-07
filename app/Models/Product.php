<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Category;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations, Auditable;

    public $translatable = ['name'];
    /**
     * The attributes that are mass searchable.
     *
     * @var array
     */
    public static $searchable = [
        'name'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 
        'price', 
        'category_id', 
        'image'
    ];
    /**
     * The attributes that should be append to native types.
     *
     * @var array
     */
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return Storage::url($this->image);
    }//end of image path attribute
    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}//end of model
