<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BrandRequests\StoreBrandRequest;
use App\Http\Requests\V1\BrandRequests\UpdateBrandRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Brand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(): View
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brand.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $brand = new Brand();
            $brand->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            DB::commit();
            return redirect()->route('brand.index')->withSuccess('Brand created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Brand creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create brand. Please try again.');
        }
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $brand->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $this->imageService->deleteImage($brand->image, 'brands');
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            DB::commit();
            return redirect()->route('brand.index')->withSuccess('Brand updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Brand update failed: ' . $e->getMessage());
            return back()->withError('Failed to update brand. Please try again.');
        }
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $brand->delete();
            $this->imageService->deleteImage($brand->image, 'brands');

            DB::commit();
            return redirect()->route('brand.index')->withSuccess('Brand deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Brand deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete brand. Please try again.');
        }
    }
}
