<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DriverRequest;

class DriverController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:read_drivers'])->only('index');
        $this->middleware(['permission:create_drivers'])->only('create');
        $this->middleware(['permission:update_drivers'])->only('edit');
        $this->middleware(['permission:delete_drivers'])->only('destroy');
    } //end of constructor

    public function index(Request $request)
    {
        $drivers = Driver::when($request->search, function ($query) use ($request) {

            return $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('nota', 'like', '%' . $request->search . '%');
        })
            ->latest()
            ->paginate();

        return view('dashboard.drivers.index', compact('drivers'));
    } //end of index

    public function create()
    {
        return view('dashboard.drivers.create');
    } //end of create

    public function store(Request $request)
    {
        $request_data = $request->validated();
        $request_data['phone'] = array_filter($request->phone);
        Driver::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.drivers.index');
    } //end of store

    public function edit(Driver $driver)
    {
        return view('dashboard.drivers.edit', compact('driver'));
    } //end of edit

    public function update(DriverRequest $request, Driver $driver)
    {
        $request_data = $request->validated();
        $request_data['phone'] = array_filter($request->phone);

        $driver->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.drivers.index');
    } //end of update

    public function destroy(Driver $driver)
    {
        $driver->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.drivers.index');
    } //end of destroy

} //end of controller
