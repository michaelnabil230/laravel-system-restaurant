<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:read_categories'])->only('index');
        $this->middleware(['permission:create_categories'])->only('create');
        $this->middleware(['permission:update_categories'])->only('edit');
        $this->middleware(['permission:delete_categories'])->only('destroy');
    } //end of constructor

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($query) use ($request) {

            return $query->where('name->en', 'like', '%' . $request->search . '%')
                ->orWhere('name->ar', 'like', '%' . $request->search . '%');
        })
            ->withCount('products')
            ->latest()
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    } //end of index

    public function create()
    {
        return view('dashboard.categories.create');
    } //end of create

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        session()->flash('success', __('site.added_successfully'));
        return back();
    } //end of store

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    } //end of edit

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    } //end of update

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    } //end of destroy

}//end of controller
