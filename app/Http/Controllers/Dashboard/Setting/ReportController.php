<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController 
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'from_at' => 'required',
            'to_at' => 'required',
        ]);

        $from = $request->date('from_at');
        $to = $request->date('to_at');

        $orders = Order::whereBetween('created_at', [$from, $to]);
        $orders_total = $orders->sum('total_price');
        $orders = $orders->orderBy('total_price', 'desc')->get();
        $data = [
            'orders' => $orders,
            'orders_total' => $orders_total,
        ];

        return view('dashboard.reports.orders', $data);
    }
}
