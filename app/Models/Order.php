<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Auditable;
    /**
     * The attributes that are mass searchable.
     *
     * @var array
     */
    public static $searchable = [
        'id', 'status'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_price', 
        'finel_total_price',
        'status', 
        'note',
        'sale', 
        'paid',
        'type_status', 
        'payment',
        'user_id', 
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
        'cash', 'mada',
        'master_card', 'visa',
    ];
    /**
     * The products that belong to the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the driver that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function getTypePaymentAttribute($value)
    {
        $name = $this::TypePayment[(int)$value];
        return [
            'index' => (int)$value,
            'type_payment' => __('site.type_payments.' . $name),
            'logo_brand' => asset('type_payments/' . $name . '-logo.svg'),
        ];
    } //end of get type_payment attribute

    public function getStatusAttribute($value)
    {
        return [
            'index' => (int)$value,
            'status' => __('site.order_status.' . $this::OrderStatus[(int)$value]),
        ];
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
    } //end of scope Sales30
} //end of model
