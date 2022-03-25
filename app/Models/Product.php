<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name',
        'price',
        'category_id',
    ];

    /**
     * Get the category that owns the Product
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that belong to the Product
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}