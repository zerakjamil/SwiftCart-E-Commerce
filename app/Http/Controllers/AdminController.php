<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        return view('admin.brands', [
            'brands' => Brand::latest()->paginate(10)
        ]);
    }

    public function createBrand()
    {
        return view('admin.create-brand');
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate(BrandRequest::rules());

        try {
            $brand = new Brand();
            $brand->fillBrandData($validated);

            if ($request->hasFile('image')) {
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            return redirect()->route('admin.brands')->withSuccess('Brand created successfully.');

        } catch (\Exception $e) {
            Log::error('Brand creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create brand. Please try again.');
        }
    }

    public function editBrand(Brand $brand)
    {
        return view('admin.edit-brand', compact('brand'));
    }

    public function updateBrand(Brand $brand, Request $request)
    {
        $validated = $request->validate(BrandRequest::updateRules($brand));

        try {
            $brand->fillBrandData($validated);

            if ($request->hasFile('image')) {
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            return redirect()->route('admin.brands')->withSuccess('Brand updated successfully.');

        } catch (\Exception $e) {
            Log::error('Brand update failed: ' . $e->getMessage());
            return back()->withError('Failed to update brand. Please try again.');
        }
    }

    public function deleteBrand(Brand $brand)
    {
        try {
            $brand->delete();
            $this->imageService->deleteImage($brand->image, 'brands');
            return redirect()->route('admin.brands')->withSuccess('Brand deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Brand deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete brand. Please try again.');
        }
    }
}
