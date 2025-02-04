<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\V1\CategoryRequests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Category;
use Illuminate\Container\Attributes\Log;

class CategoryController extends Controller
{
    protected ImageService $imageService;
    public function __construct()
    {
        $this->imageService = new ImageService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index', [
            'categories' => Category::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
