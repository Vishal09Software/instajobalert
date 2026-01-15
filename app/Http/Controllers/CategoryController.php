<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        $parentCategories = JobCategory::whereNull('parent_id')->where('status', true)->with('parent')->get();
        return view('admin.category.create', compact('parentCategories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        JobCategory::create($data);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(JobCategory $category)
    {
        $parentCategories = JobCategory::whereNull('parent_id')->where('status', true)->with('parent')->get();
        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, JobCategory $category)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }
}
