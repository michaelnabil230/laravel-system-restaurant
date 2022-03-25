<?php

namespace App\Models;

use App\Models\User;
use App\Models\Driver;
use App\Models\Product;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use Auditable;

    /**
     * The attributes that are mass searchable.
     *
     * @var array
     */
    public static $searchable = [
        'id',
        'status'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total_price',
        'final_total_price',
        'status',
        'note',
        'sale',
        'paid',
        'type_status',
        'payment',
        'admin_id',
        'driver_id'
    ];

    const OrderStatus = [
        'the_receipt_of_the_request',
        'the_order_has_been_confirmed',
        'the_request_is_being_prepared',
        'order_is_in_progress',
        'finished'
    ];

    const TypePayment = [
        'cash',
        'mada',
        'master_card',
        'visa',
    ];

    /**
     * The products that belong to the Order
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    /**
     * Get the admin that owns the Order
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'admin_id');
    }

    /**
     * Get the driver that owns the Order
     *
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get or Set the order's typePayment.
     *
     * @return Attribute
     */
    protected function typePayment(): Attribute
    {
        return new Attribute(
            get: fn ($value) => [
                'index' => (int) $value,
                'type_payment' => __('tenant.type_payments.' . $this::TypePayment[(int) $value]),
            ],
        );
    }

    /**
     * Get or Set the order's status.
     *
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return new Attribute(
            get: fn ($value) => [
                'index' => (int) $value,
                'status' => __('tenant.order_status.' . $this::OrderStatus[(int) $value]),
            ],
        );
    }

    /**
     * Scope a query to only by year and Month.
     *
     * @param Builder $query
     * @param mixed $year
     * @param mixed $month
     * @return Builder
     */
    public function scopeByYearAndMonth(Builder $query, $year, $month)
    {
        return $query
            ->selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,SUM(total_price) AS total_price')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get()
            ->keyBy('md')
            ->toArray();
    }

    /**
     * Scope a query to only by year.
     *
     * @param Builder $query
     * @param mixed $year
     * @return Builder
     */
    public function scopeByYear(Builder $query, $year)
    {
        return $query
            ->selectRaw('MONTH(created_at) AS month,SUM(total_price) AS total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
    }

    /**
     * Scope a query to only by sales 30.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSales30(Builder $query)
    {
        return $query
            ->selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,SUM(total_price) AS total_amount')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), "%Y-%m-%d 00:00")')
            ->groupBy('md')
            ->get()
            ->keyBy('md')
            ->toArray();
    }
}
