<?php

namespace App\Http\Controllers\Dashboard;

use App\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $drivers = Driver::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('nota', 'like', '%' . $request->search . '%');

        })->latest()->paginate();

        return view('dashboard.drivers.index', compact('drivers'));

    } //end of index

    public function create()
    {
        return view('dashboard.drivers.create');

    } //end of create

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
        ]);

        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone);
        Driver::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.drivers.index');

    } //end of store

    public function edit(Driver $driver)
    {
        return view('dashboard.drivers.edit', compact('driver'));
    } //end of edit

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
        ]);

        $request_data = $request->all();
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
