<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Driver;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');

    } //end of constructor

    public function index(Request $request)
    {
        $orders = Order::when($request->search, function ($query) use ($request) {
            return $query->Where('id', $request->search);
        })->latest()->paginate();
        return view('dashboard.orders.index', compact('orders'));

    } //end of index

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
        $form_btn_order_name = __('site.add_order');
        $form_btn_order_icon = 'fa fa-plus';

        return view('dashboard.orders.create', compact(
            'categories', 'order', 'url',
            'method', 'form_btn_order_name', 'form_btn_order_icon',
            'drivers'
        ));

    } //end of create

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'type_status' => 'required',
            'payment' => 'required',
        ]);
        $this->CreateOrUpdate($request);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    } //end of store

    private function CreateOrUpdate($request)
    {
        $total_price = 0;
        foreach ($request->products as $id => $quantity) {
            $product = Product::FindOrFail($id);
            $total_price += $product->price * $quantity['quantity'];
        } //end of foreach

        $sale = $request->sale;
        $finel_total_price = $sale > 0 ? $total_price - ($total_price * $sale / 100) : $total_price;
        $finel_total_price = ($finel_total_price * setting('value_added') / 100) + $finel_total_price;

        $request_data = $request->except(['products']);
        $request_data['total_price'] = $total_price;
        $request_data['finel_total_price'] = $finel_total_price;
        $request_data['user_id'] = Auth::id();

        $order = Order::create($request_data);
        $order->products()->attach($request->products);
    } //end of CreateOrUpdate

    public function edit(Order $order)
    {
        $categories = Category::orderBy('position', 'asc')->with('products')->whereHas('products')->latest()->get();
        $url = route('dashboard.orders.update', $order->id);
        $method = 'put';
        $form_btn_order_name = __('site.edit_order');
        $form_btn_order_icon = 'fa fa-edit';

        $quantity_products = $order->products->pluck('pivot.quantity', 'id')->toArray();

        $drivers = Driver::get();
        return view('dashboard.orders.edit', compact(
            'categories', 'order', 'quantity_products',
            'url', 'method', 'form_btn_order_name',
            'form_btn_order_icon', 'drivers'
        ));

    } //end of edit order

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'products' => 'required|array',
        ]);
        $order->delete();

        $this->CreateOrUpdate($request);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of update order

    public function offline(Request $request)
    {
        foreach ($request->orders as $order) {
            $request = json_decode($order, true);
            $request['nota'] = null;
            $this->CreateOrUpdate((object) $request);
        }

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    } //end of offline order

    public function destroy(Order $order)
    {
        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');

    }

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    } //end of products

    public function update_status(Order $order)
    {
        if ($order->status == __('site.order_status.the_receipt_of_the_request')) {
            $status = 'the_order_has_been_confirmed';
        } elseif ($order->status == __('site.order_status.the_order_has_been_confirmed')) {
            $status = 'the_request_is_being_prepared';
        } elseif ($order->status == __('site.order_status.the_request_is_being_prepared')) {
            $status = 'order_is_in_progress';
        } elseif ($order->status == __('site.order_status.order_is_in_progress')) {
            $status = 'delivered';
        }
        $order->update([
            'status' => $status,
        ]);
        return response()->json([
            'text' => __('site.order_status.' . $status),
            'success' => __('site.updated_successfully'),
        ]);
    }
} //end of controller
