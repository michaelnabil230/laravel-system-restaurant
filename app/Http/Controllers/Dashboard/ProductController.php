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
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:create_products'])->only('create');
        $this->middleware(['permission:update_products'])->only('edit');
        $this->middleware(['permission:delete_products'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::query()
            ->when($request->search, function ($query) use ($request) {
                return $query
                    ->Where('name->ar', 'like', '%' . $request->search . '%')
                    ->orWhere('name->en', 'like', '%' . $request->search . '%');
            })
            ->when($request->category_id, function ($q) use ($request) {
                return $q->where('category_id', $request->category_id);
            })
            ->with('category')
            ->latest()
            ->paginate();

        return view('dashboard.products.index', compact('categories', 'products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->safe()->except(['image']);

        if ($request->image) {
            $validated['image'] = $request->image->store('public/products');
        }

        Product::create($validated);
        session()->flash('success', __('dashboard.added_successfully'));
        return back();
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->safe()->except(['image']);

        if ($request->image) {
            if ($product->image != 'public/products/default.png') {
                Storage::delete($product->image);
            }
            $validated['image'] = $request->image->store('public/products');
        }

        $product->update($validated);
        session()->flash('success', __('dashboard.updated_successfully'));
        return to_route('dashboard.products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image != 'public/products/default.png') {
            Storage::delete($product->image);
        }

        $product->delete();
        session()->flash('success', __('dashboard.deleted_successfully'));
        return to_route('dashboard.products.index');
    }
}
