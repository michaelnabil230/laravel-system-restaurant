<?php

namespace App\Http\Controllers\Dashboard;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\{
    User,
    Order,
    Product,
    Category,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $admins_count = User::role('admin')->count();
        $orders_count = Order::count();
        $categories_count = Category::count();
        $products_count = Product::count();
        $orders = Order::take(15)->latest()->get();
        $chart = $this->chart();

        return view('dashboard.welcome', compact('admins_count', 'orders_count', 'categories_count', 'products_count', 'orders', 'chart'));
    }

    private function chart()
    {
        /* Start data Years  */
        $ThisYear = Order::ByYear(date("Y"));
        $LastYear = Order::ByYear(date("Y", strtotime(date('Y') . " -1 year")));

        for ($i = 1; $i < 13; $i++) {
            $Sales2YearsThisYear[] = $ThisYear[$i] ?? 0;
            $Sales2YearsLastYear[] = $LastYear[$i] ?? 0;
        }
        $Sales2YearsLabelsMonths = json_encode(array_values(cal_info(0)['months']));
        $Sales2YearsThisYear = json_encode($Sales2YearsThisYear);
        $Sales2YearsLastYear = json_encode($Sales2YearsLastYear);

        /* End data Years  */

        /* Order in 30 days */
        $totalsInMonth = Order::Sales30();

        $rangDays = new DatePeriod(
            new DateTime('-1 month'),
            new DateInterval('P1D'),
            new DateTime('+1 day')
        );
        foreach ($rangDays as $i => $day) {
            $sales30DayesLabelsInMonth[] = $date = $day->format('m-d');
            $dataInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);
        }
        $sales30DayesDataInMonth = json_encode(array_values($dataInMonth));
        $sales30DayesLabelsInMonth = json_encode($sales30DayesLabelsInMonth);
        /* End Order in 30 days */
        return [
            'Sales2YearsLabelsMonths' => $Sales2YearsLabelsMonths,
            'Sales2YearsThisYear' => $Sales2YearsThisYear,
            'Sales2YearsLastYear' => $Sales2YearsLastYear,
            'sales30DayesDataInMonth' => $sales30DayesDataInMonth,
            'sales30DayesLabelsInMonth' => $sales30DayesLabelsInMonth,
        ];
    }

    public function day(Request $request)
    {
        $request->validate([
            'day' => 'required',
        ]);
        $sales = Order::whereDate('created_at', date('Y') . '-' . $request->day)->select(
            DB::raw('Time(created_at) as time'),
            DB::raw('SUM(total_price) as total_price')
        )->groupBy('time')->get();
        $dataDay = [];
        foreach ($sales as $i => $sale) {
            $time = Carbon::createFromFormat('H:i:s', $sale->time)->format('g:i:s A');
            $dataDay[$time] = $sale->total_price;
        }
        $Sales30DayesDataDay = array_values($dataDay);
        $Sales30DayesLabelsDay = array_keys($dataDay);
        return response()->json([
            'Sales30DayesDataDay' => $Sales30DayesDataDay,
            'Sales30DayesLabelsDay' => $Sales30DayesLabelsDay,
            'text' => __('dashboard.sales_day', ['day' => date('Y') . '-' . $request->day]),
        ]);
    }

    public function month(Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);
        $month = Carbon::createFromFormat('m', $request->month)->format('m');

        $InYaerInMonth = Order::ByYearAndMonth(date("Y"), $month);
        $InLastYaerInMonth = Order::ByYearAndMonth(date("Y", strtotime(date('Y') . " -1 year")), $month);

        for ($i = 1; $i < 32; $i++) {
            $Sales2YearsLabels[] = $date = $month . '-' . Carbon::createFromFormat('d', $i)->format('d');
            $Sales2YearsYearInMonth[$date] = ($InYaerInMonth[$date]['total_price'] ?? 0);
            $Sales2YearsLastYearInMonth[$date] = ($InLastYaerInMonth[$date]['total_price'] ?? 0);
        }
        $Sales2YearsYearInMonth = array_values($Sales2YearsYearInMonth);
        $Sales2YearsLastYearInMonth = array_values($Sales2YearsLastYearInMonth);

        return response()->json([
            'Sales2YearsYearInMonth' => $Sales2YearsYearInMonth,
            'Sales2YearsLastYearInMonth' => $Sales2YearsLastYearInMonth,
            'Sales2YearsLabels' => $Sales2YearsLabels,
            'text' => __('dashboard.sales_month', ['month' => date("F", mktime(0, 0, 0, $month, 10))]),
        ]);
    }
}
