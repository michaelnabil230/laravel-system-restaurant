<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use DB;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories_count = Category::count();
        $products_count = Product::count();
        $orders_count = Order::count();
        $users_count = User::role('admin')->count();
        $orders = Order::take(15)->latest()->get();

        /* Start products most  */
        $products_most = Product::select(['name_ar', 'name_en'])
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(15)
            ->get()
            ->makeHidden(['image_path', 'name_ar', 'name_en']);
        $labels = $products_most->pluck('name')->toJson();
        $data_count = $products_most->pluck('orders_count')->toJson();
        $colors = [];

        for ($i = 0; $i < count($products_most); $i++) {
            $colors[] = $this->random_color();
        }
        $colors = json_encode($colors);
        /* End products most  */

        /* Start data Years  */

        $ThisYear = Order::selectRaw('MONTH(created_at) AS month,SUM(total_price) AS total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $LastYear = Order::selectRaw('MONTH(created_at) AS month,SUM(total_price) AS total')
            ->whereYear('created_at', date("Y", strtotime(date('Y') . " -1 year")))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        for ($i = 1; $i < 12; $i++) {
            $dataInThisYear[] = $ThisYear[$i] ?? 0;
            $dataInLastYear[] = $LastYear[$i] ?? 0;
        }
        $months = json_encode(array_values(cal_info(0)['months']));
        $dataInThisYear = json_encode($dataInThisYear);
        $dataInLastYear = json_encode($dataInLastYear);

        /* End data Years  */

        /* Order in 30 days */
        $totalsInMonth = Order::selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,SUM(total_price) AS total_amount')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), "%Y-%m-%d 00:00")')
            ->groupBy('md')
            ->get()
            ->keyBy('md')
            ->toArray();

        $rangDays = new \DatePeriod(
            new \DateTime('-1 month'),
            new \DateInterval('P1D'),
            new \DateTime('+1 day')
        );
        foreach ($rangDays as $i => $day) {
            $date = $day->format('m-d');
            $dataInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);
        }
        $ordersDataInMonth = json_encode(array_values($dataInMonth));
        $ordersLabelsInMonth = json_encode(array_keys($dataInMonth));
        /* End Order in 30 days */

        return view('dashboard.welcome', compact(
            'categories_count', 'products_count',
            'orders_count', 'users_count',
            'orders',
            'labels', 'data_count', 'colors',
            'months', 'dataInThisYear', 'dataInLastYear',
            'ordersLabelsInMonth', 'ordersDataInMonth'
        ));

    } //end of index

    public function random_color()
    {
        return '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    } //end of random_color_part

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    } //end of random_color

    public function day(Request $request)
    {
        $orders = Order::whereDate('created_at', '2020-' . $request->day)->select(
            DB::raw('Time(created_at) as time'),
            DB::raw('SUM(total_price) as total_price')
        )->groupBy('time')->get();

        foreach ($orders as $i => $order) {
            $time = \Carbon\Carbon::createFromFormat('H:i:s', $order->time)->format('g:i:s A');
            $dataDay[$time] = $order->total_price;
        }
        $ordersDataDay = array_values($dataDay);
        $ordersLabelsDay = array_keys($dataDay);
        return response()->json([
            'ordersLabelsDay' => $ordersLabelsDay,
            'ordersDataDay' => $ordersDataDay,

        ]);
    }

} //end of controller
