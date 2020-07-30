<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'total_price',
        'status', 'note',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    } //end of products

    public function getStatusAttribute($value)
    {
        return __('site.order_status.' . $value);

    } //end of get status attribute
    public function scopeByYearAndMonth($query, $year, $month)
    {
        return $query->selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,SUM(total_price) AS total_price')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get()
            ->keyBy('md')
            ->toArray();
    } //end of scope ByYearAndOrMonth
    public function scopeByYear($query, $year)
    {
        return $query->selectRaw('MONTH(created_at) AS month,SUM(total_price) AS total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
    } //end of scope ByYear

    public function scopeSales30($query)
    {
        return $query->selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,SUM(total_price) AS total_amount')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), "%Y-%m-%d 00:00")')
            ->groupBy('md')
            ->get()
            ->keyBy('md')
            ->toArray();
    }
} //end of model
