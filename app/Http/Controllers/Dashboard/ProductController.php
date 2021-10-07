<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:create_products'])->only('create');
        $this->middleware(['permission:update_products'])->only('edit');
        $this->middleware(['permission:delete_products'])->only('destroy');
    } //end of constructor

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($query) use ($request) {

            return $query->Where('name->ar', 'like', '%' . $request->search . '%')
                ->orWhere('name->en', 'like', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })
            ->with('category')
            ->latest()
            ->paginate();

        return view('dashboard.products.index', compact('categories', 'products'));
    } //end of index

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    } //end of create

    public function store(ProductRequest $request)
    {
        $request_data = $request->safe()->except(['image']);

        if ($request->image) {
            $request_data['image'] = $request->image->store('public/products');
        } //end of if
        Product::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return back();
    } //end of store

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));
    } //end of edit

    public function update(Request $request, Product $product)
    {
        $request_data = $request->safe()->except(['image']);

        if ($request->image) {
            if ($product->image != 'public/products/default.png') {
                Storage::delete($product->image);
            } //end of if
            $request_data['image'] = $request->image->store('public/products');
        } //end of if

        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    } //end of update

    public function destroy(Product $product)
    {
        if ($product->image != 'public/products/default.png') {
            Storage::delete($product->image);
        } //end of if

        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    } //end of destroy

} //end of controller
