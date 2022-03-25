<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');
    }

    public function index(Request $request)
    {
        $orders = Order::query()
            ->when($request->search, function ($query) use ($request) {
                return $query->Where('id', $request->search);
            })
            ->latest()
            ->paginate();

        return view('dashboard.orders.index', compact('orders'));
    }

    public function create()
    {
        $order = null;
        $drivers = Driver::get();
        $categories = Category::orderBy('position', 'desc')
            ->with(['products' => function ($q) {
                return $q->withCount('orders')->orderBy('orders_count', 'desc');
            }])->whereHas('products')
            ->latest()
            ->get();

        $url = route('dashboard.orders.store');
        $method = 'Post';
        $form_btn_order_name = __('dashboard.add_order');
        $form_btn_order_icon = 'fa fa-plus';

        return view('dashboard.orders.create', compact(
            'categories',
            'order',
            'url',
            'method',
            'form_btn_order_name',
            'form_btn_order_icon',
            'drivers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'type_status' => 'required',
            'payment' => 'required',
        ]);
        $this->createOrUpdate($request);

        session()->flash('success', __('dashboard.added_successfully'));
        return to_route('dashboard.orders.index');
    }

    private function createOrUpdate($request)
    {
        $total_price = 0;
        foreach ($request->products as $id => $quantity) {
            $product = Product::findOrFail($id);
            $total_price += $product->price * $quantity['quantity'];
        }

        $sale = $request->sale;
        $final_total_price = $sale > 0 ? $total_price - ($total_price * $sale / 100) : $total_price;
        $final_total_price = ($final_total_price * setting('value_added') / 100) + $final_total_price;

        $validated = [
            'admin_id' => auth()->id(),
            'total_price' => $total_price,
            'final_total_price' => $final_total_price,
            'sale' => $sale,
            'paid' => $request->paid,
            'note' => $request->note,
            'type_status' => $request->type_status,
            'payment' => $request->payment,
            'driver_id' => $request->driver_id,
        ];

        $order = Order::create($validated);
        $order->products()->attach($request->products);
    }

    public function edit(Order $order)
    {
        $drivers = Driver::get();
        $categories = Category::orderBy('position', 'asc')->with('products')->whereHas('products')->latest()->get();
        $url = route('dashboard.orders.update', $order->id);
        $method = 'put';
        $form_btn_order_name = __('dashboard.edit_order');
        $form_btn_order_icon = 'fa fa-edit';
        $quantity_products = $order->products->pluck('pivot.quantity', 'id')->toArray();

        return view('dashboard.orders.edit', compact(
            'categories',
            'order',
            'quantity_products',
            'url',
            'method',
            'form_btn_order_name',
            'form_btn_order_icon',
            'drivers'
        ));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'products' => ['required', 'array'],
        ]);

        $order->delete();
        $this->createOrUpdate($request);

        session()->flash('success', __('dashboard.updated_successfully'));
        return to_route('dashboard.orders.index');
    }

    public function offline(Request $request)
    {
        foreach ($request->orders as $order) {
            $request = json_decode($order, true);
            $this->createOrUpdate((object) $request);
        }

        session()->flash('success', __('dashboard.added_successfully'));
        return to_route('dashboard.orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        session()->flash('success', __('dashboard.deleted_successfully'));
        return to_route('dashboard.orders.index');
    }

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));
    }

    public function update_status(Order $order)
    {
        if ($order->status['index'] != 4) {
            $order->increment('status');
        }

        return response()->json([
            'text' => $order->status['status'],
            'index' => $order->status['index'],
            'success' => __('dashboard.updated_successfully'),
        ]);
    }
}
