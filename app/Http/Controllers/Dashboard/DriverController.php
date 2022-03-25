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
        $this->middleware(['permission:read_drivers'])->only('index');
        $this->middleware(['permission:create_drivers'])->only('create');
        $this->middleware(['permission:update_drivers'])->only('edit');
        $this->middleware(['permission:delete_drivers'])->only('destroy');
    }

    public function index(Request $request)
    {
        $drivers = Driver::query()
            ->when($request->search, function ($query) use ($request) {
                return $query
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('nota', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate();

        return view('dashboard.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('dashboard.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validated();
        $validated['phone'] = array_filter($request->phone);
        Driver::create($validated);
        session()->flash('success', __('dashboard.added_successfully'));
        return to_route('dashboard.drivers.index');
    }

    public function edit(Driver $driver)
    {
        return view('dashboard.drivers.edit', compact('driver'));
    }

    public function update(DriverRequest $request, Driver $driver)
    {
        $validated = $request->validated();
        $validated['phone'] = array_filter($request->phone);

        $driver->update($validated);
        session()->flash('success', __('dashboard.updated_successfully'));
        return to_route('dashboard.drivers.index');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        session()->flash('success', __('dashboard.deleted_successfully'));
        return to_route('dashboard.drivers.index');
    }
}
