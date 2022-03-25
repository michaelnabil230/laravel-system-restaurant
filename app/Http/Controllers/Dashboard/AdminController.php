<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Order;
use App\Models\User as Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_admins'])->only('index');
        $this->middleware(['permission:create_admins'])->only('create');
        $this->middleware(['permission:update_admins'])->only('edit');
        $this->middleware(['permission:delete_admins'])->only('destroy');
    }

    public function index(Request $request)
    {
        $admins = Admin::query()
            ->role('admin')->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate();

        return view('dashboard.admins.index', compact('admins'));
    }

    public function show(Admin $admin)
    {
        /* Start data Years  */
        $thisYear = Order::where('admin_id', $admin->id)->ByYear(date("Y"));
        $lastYear = Order::where('admin_id', $admin->id)->ByYear(date("Y", strtotime(date('Y') . " -1 year")));

        for ($i = 1; $i < 12; $i++) {
            $sales2YearsThisYear[] = $thisYear[$i] ?? 0;
            $sales2YearsLastYear[] = $lastYear[$i] ?? 0;
        }
        $sales2YearsLabelsMonths = json_encode(array_values(cal_info(0)['months']));
        $sales2YearsThisYear = json_encode($sales2YearsThisYear);
        $sales2YearsLastYear = json_encode($sales2YearsLastYear);

        /* End data Years  */

        /* Order in 30 days */
        $totalsInMonth = Order::where('admin_id', $admin->id)->Sales30();

        $rangDays = new \DatePeriod(
            new \DateTime('-1 month'),
            new \DateInterval('P1D'),
            new \DateTime('+1 day')
        );
        foreach ($rangDays as $i => $day) {
            $sales30DaysLabelsInMonth[] = $date = $day->format('m-d');
            $dataInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);
        }
        $sales30DaysDataInMonth = json_encode(array_values($dataInMonth));
        $sales30DaysLabelsInMonth = json_encode($sales30DaysLabelsInMonth);
        /* End Order in 30 days */

        return view('dashboard.users.show', compact(
            'user',
            'sales2YearsLabelsMonths',
            'sales2YearsThisYear',
            'Sales2YearsLastYear',
            'sales30DaysDataInMonth',
            'sales30DaysLabelsInMonth'
        ));
    }

    public function day(Admin $admin, Request $request)
    {
        $request->validate([
            'day' => 'required',
        ]);

        $sales = Order::where('admin_id', $admin->id)
            ->whereDate('created_at', '2020-' . $request->day)
            ->select(
                DB::raw('Time(created_at) as time'),
                DB::raw('SUM(total_price) as total_price')
            )
            ->groupBy('time')
            ->get();

        $dataDay = [];
        foreach ($sales as $i => $sale) {
            $time = Carbon::createFromFormat('H:i:s', $sale->time)->format('g:i:s A');
            $dataDay[$time] = $sale->total_price;
        }

        $sales30DaysDataDay = array_values($dataDay);
        $sales30DaysLabelsDay = array_keys($dataDay);

        return response()->json([
            'sales30DaysDataDay' => $sales30DaysDataDay,
            'sales30DaysLabelsDay' => $sales30DaysLabelsDay,
            'text' => __('dashboard.sales_day', ['day' => '2020-' . $request->day]),
        ]);
    }

    public function month(Admin $admin, Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);

        $month = \Carbon\Carbon::createFromFormat('m', $request->month)->format('m');

        $inYearInMonth = Order::where('admin_id', $admin->id)->ByYearAndMonth(date("Y"), $month);
        $inLastYearInMonth = Order::where('admin_id', $admin->id)->ByYearAndMonth(date("Y", strtotime(date('Y') . " -1 year")), $month);

        for ($i = 1; $i < 32; $i++) {
            $sales2YearsLabels[] = $date = $month . '-' . $i;
            $sales2YearsYearInMonth[$date] = ($inYearInMonth[$date]['total_price'] ?? 0);
            $sales2YearsLastYearInMonth[$date] = ($inLastYearInMonth[$date]['total_price'] ?? 0);
        }

        $sales2YearsYearInMonth = array_values($sales2YearsYearInMonth);
        $sales2YearsLastYearInMonth = array_values($sales2YearsLastYearInMonth);

        return response()->json([
            'sales2YearsYearInMonth' => $sales2YearsYearInMonth,
            'sales2YearsLastYearInMonth' => $sales2YearsLastYearInMonth,
            'sales2YearsLabels' => $sales2YearsLabels,
            'text' => __('dashboard.sales_month', ['month' => date("F", strtotime($month))]),
        ]);
    }

    public function create()
    {
        return view('dashboard.admins.create');
    }

    public function store(AdminRequest $request)
    {
        $validated = $request->safe()->except(['password_confirmation', 'permissions']);

        $admin = Admin::create($validated);
        $admin->syncRoles('admin');
        $admin->syncPermissions($request->permissions);

        session()->flash('success', __('dashboard.added_successfully'));

        return to_route('dashboard.admins.index');
    }

    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit', compact('admin'));
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $validated = $request->safe()->except(['password_confirmation', 'permissions']);

        $admin->update($validated);
        $admin->syncPermissions($request->permissions);

        session()->flash('success', __('dashboard.updated_successfully'));

        return to_route('dashboard.admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        session()->flash('success', __('dashboard.deleted_successfully'));

        return to_route('dashboard.admins.index');
    }
}
