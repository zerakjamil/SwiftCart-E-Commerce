<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function createBrand()
    {
        return view('admin.create-brand');
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:brands,slug|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->slug); // Ensure slug format

            // Generate unique filename
            $image = $request->file('image');
            $fileName = Carbon::now()->timestamp . '_' . Str::random(10) . '.' . $image->guessExtension();

            // Process and save image
            $this->generateBrandThumbnailsImage($image, $fileName);
            $brand->image = $fileName;
            $brand->save();

            return redirect()->route('admin.brands')->with('success', 'Brand created successfully.');

        } catch (\Exception $e) {
            Log::error('Brand creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create brand. Please try again.');
        }
    }

    public function generateBrandThumbnailsImage($image, $imageName): void
    {
        $destinationPath = public_path('uploads/brands');

        // Create directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Resize and save image
        $img = Image::read($image->path());
        $img->cover(123,124,"top");
        $img->resize(124, 124,function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
}
