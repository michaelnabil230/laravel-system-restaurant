<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations, Auditable;

    /**
     * The attributes that are mass searchable.
     *
     * @var array
     */
    public static $searchable = [
        'name'
    ];
    public $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position'
    ];
    /**
     * Get all of the products for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () {
            return $this->save();
        });
    }
}//end of model
