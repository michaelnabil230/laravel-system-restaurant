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
        $ThisYear = Order::ByYear(date("Y"));
        $LastYear = Order::ByYear(date("Y", strtotime(date('Y') . " -1 year")));

        for ($i = 1; $i < 12; $i++) {
            $Sales2YearsThisYear[] = $ThisYear[$i] ?? 0;
            $Sales2YearsLastYear[] = $LastYear[$i] ?? 0;
        }
        $Sales2YearsLabelsMonths = json_encode(array_values(cal_info(0)['months']));
        $Sales2YearsThisYear = json_encode($Sales2YearsThisYear);
        $Sales2YearsLastYear = json_encode($Sales2YearsLastYear);

        /* End data Years  */

        /* Order in 30 days */
        $totalsInMonth = Order::Sales30();

        $rangDays = new \DatePeriod(
            new \DateTime('-1 month'),
            new \DateInterval('P1D'),
            new \DateTime('+1 day')
        );
        foreach ($rangDays as $i => $day) {
            $sales30DayesLabelsInMonth[] = $date = $day->format('m-d');
            $dataInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);
        }
        $sales30DayesDataInMonth = json_encode(array_values($dataInMonth));
        $sales30DayesLabelsInMonth = json_encode($sales30DayesLabelsInMonth);
        /* End Order in 30 days */

        return view('dashboard.welcome', compact(
            'categories_count', 'products_count',
            'orders_count', 'users_count',
            'orders',
            'labels', 'data_count', 'colors',
            'Sales2YearsLabelsMonths', 'Sales2YearsThisYear', 'Sales2YearsLastYear',
            'sales30DayesDataInMonth', 'sales30DayesLabelsInMonth'
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
        $request->validate([
            'day' => 'required',
        ]);
        $sales = Order::whereDate('created_at', '2020-' . $request->day)->select(
            DB::raw('Time(created_at) as time'),
            DB::raw('SUM(total_price) as total_price')
        )->groupBy('time')->get();
        $dataDay = [];
        foreach ($sales as $i => $sale) {
            $time = \Carbon\Carbon::createFromFormat('H:i:s', $sale->time)->format('g:i:s A');
            $dataDay[$time] = $sale->total_price;
        }
        $Sales30DayesDataDay = array_values($dataDay);
        $Sales30DayesLabelsDay = array_keys($dataDay);
        return response()->json([
            'Sales30DayesDataDay' => $Sales30DayesDataDay,
            'Sales30DayesLabelsDay' => $Sales30DayesLabelsDay,
            'text' => __('site.sales_day', ['day' => '2020-' . $request->day]),
        ]);
    }
    public function month(Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);
        $month = \Carbon\Carbon::createFromFormat('m', $request->month)->format('m');

        $InYaerInMonth = Order::ByYearAndMonth(date("Y"), $month);
        $InLastYaerInMonth = Order::ByYearAndMonth(date("Y", strtotime(date('Y') . " -1 year")), $month);

        for ($i = 1; $i < 32; $i++) {
            $Sales2YearsLabels[] = $date = $month . '-' . $i;
            $Sales2YearsYearInMonth[$date] = ($InYaerInMonth[$date]['total_price'] ?? 0);
            $Sales2YearsLastYearInMonth[$date] = ($InLastYaerInMonth[$date]['total_price'] ?? 0);
        }
        $Sales2YearsYearInMonth = array_values($Sales2YearsYearInMonth);
        $Sales2YearsLastYearInMonth = array_values($Sales2YearsLastYearInMonth);

        return response()->json([
            'Sales2YearsYearInMonth' => $Sales2YearsYearInMonth,
            'Sales2YearsLastYearInMonth' => $Sales2YearsLastYearInMonth,
            'Sales2YearsLabels' => $Sales2YearsLabels,
            'text' => __('site.sales_month', ['month' => date("F", strtotime($month))]),
        ]);
    }
} //end of controller
