<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_categories'])->only('index');
        $this->middleware(['permission:create_categories'])->only('create');
        $this->middleware(['permission:update_categories'])->only('edit');
        $this->middleware(['permission:delete_categories'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->search, function ($query) use ($request) {
                return $query
                    ->where('name->en', 'like', '%' . $request->search . '%')
                    ->orWhere('name->ar', 'like', '%' . $request->search . '%');
            })
            ->withCount('products')
            ->latest()
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        session()->flash('success', __('dashboard.added_successfully'));

        return back();
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        session()->flash('success', __('dashboard.updated_successfully'));

        return to_route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('dashboard.deleted_successfully'));

        return to_route('dashboard.categories.index');
    }
}
