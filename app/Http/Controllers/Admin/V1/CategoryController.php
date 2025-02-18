<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\V1\CategoryRequests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(): View
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.category.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $category = new Category();
            $category->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $category->image = $this->imageService->saveImage($request->file('image'), 'categories');
            }

            $category->save();

            DB::commit();
            return redirect()->route('category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Category creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create category. Please try again.');
        }
    }

    public function edit(Category $category): View
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $category->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $this->imageService->deleteImage($category->image, 'categories');
                $category->image = $this->imageService->saveImage($request->file('image'), 'categories');
            }

            $category->save();

            DB::commit();
            return redirect()->route('category.index')->withSuccess('Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Category update failed: ' . $e->getMessage());
            return back()->withError('Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $category->delete();
            $this->imageService->deleteImage($category->image, 'categories');

            DB::commit();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Category deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete category. Please try again.');
        }
    }
}
