<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');

    } //end of constructor

    public function index(Request $request)
    {
        $users = User::role('admin')->when($request->search, function ($query) use ($request) {

            return $query->where('name', 'like', '%' . $request->search . '%');

        })->latest()->paginate();

        return view('dashboard.users.index', compact('users'));

    } //end of index
    public function show(User $user)
    {
        /* Start data Years  */
        $ThisYear = Order::where('user_id', $user->id)->ByYear(date("Y"));
        $LastYear = Order::where('user_id', $user->id)->ByYear(date("Y", strtotime(date('Y') . " -1 year")));

        for ($i = 1; $i < 12; $i++) {
            $Sales2YearsThisYear[] = $ThisYear[$i] ?? 0;
            $Sales2YearsLastYear[] = $LastYear[$i] ?? 0;
        }
        $Sales2YearsLabelsMonths = json_encode(array_values(cal_info(0)['months']));
        $Sales2YearsThisYear = json_encode($Sales2YearsThisYear);
        $Sales2YearsLastYear = json_encode($Sales2YearsLastYear);

        /* End data Years  */

        /* Order in 30 days */
        $totalsInMonth = Order::where('user_id', $user->id)->Sales30();

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

        return view('dashboard.users.show', compact(
            'user',
            'Sales2YearsLabelsMonths', 'Sales2YearsThisYear', 'Sales2YearsLastYear',
            'sales30DayesDataInMonth', 'sales30DayesLabelsInMonth'
        ));

    } //end of show user
    public function day(User $user, Request $request)
    {
        $request->validate([
            'day' => 'required',
        ]);
        $sales = Order::where('user_id', $user->id)->whereDate('created_at', '2020-' . $request->day)->select(
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
    public function month(User $user, Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);
        $month = \Carbon\Carbon::createFromFormat('m', $request->month)->format('m');

        $InYaerInMonth = Order::where('user_id', $user->id)->ByYearAndMonth(date("Y"), $month);
        $InLastYaerInMonth = Order::where('user_id', $user->id)->ByYearAndMonth(date("Y", strtotime(date('Y') . " -1 year")), $month);

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
    public function create()
    {
        return view('dashboard.users.create');

    } //end of create

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);

        $user = User::create($request_data);
        $user->syncRoles('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');

    } //end of store

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));

    } //end of user

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'confirm_password' => 'required_with:password|same:password',
            'permissions' => 'required|min:1',
        ]);
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);

        if ($request->password) {
            $request_data['password'] = bcrypt($request->password);
        }
        $user->update($request_data);
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');

    } //end of update

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    } //end of destroy

} //end of controller
