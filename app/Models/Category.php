<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\Auditable;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public $translatable = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'position'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::observe(CategoryObserver::class);
    }

    /**
     * Get all of the products for the Category
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
