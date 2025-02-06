<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\V1\CategoryRequests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Category;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    protected ImageService $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.category.index', [
            'categories' => Category::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validate(StoreCategoryRequest::rules());
        try{
            $category = new Category();
            $category->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $category->image = $this->imageService->saveImage($request->file('image'), 'categories');
            }

            $category->save();
            return redirect()->route('category.index')->with('success', 'Category created successfully.');
        }catch (\Exception $e){
            Log::error('Category creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, Request $request)
    {
       $validated = $request->validate(UpdateCategoryRequest::rules($category->id));

        try {
            $category->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $category->image = $this->imageService->saveImage($request->file('image'), 'categories');
            }

            $category->save();

            return redirect()->route('category.index')->withSuccess('Category updated successfully.');

        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return back()->withError('Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        Category::destroy($category->id);
        $this->imageService->deleteImage($category->image, 'categories');
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
