<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            return $query->Where('name_en', 'like', '%' . $request->search . '%')
                ->orWhere('name_ar', 'like', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->with('category')->latest()->paginate();

        return view('dashboard.products.index', compact('categories', 'products'));

    } //end of index

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));

    } //end of create

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|unique:products,name_ar',
            'name_en' => 'required|unique:products,name_en',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $request_data = $request->all();

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
        $request->validate([
            'name_ar' => 'required|unique:products,name_ar,' . $product->id,
            'name_en' => 'required|unique:products,name_en,' . $product->id,
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $request_data = $request->all();

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
