<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequests\StoreProductRequest;
use App\Http\Requests\V1\ProductRequests\UpdateProductRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Category;
use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected ImageService $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.index',[
            'products' => Product::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create',[
            'categories' => Category::select('id','name')->orderBy('name')->get(),
            'brands' => Brand::select('id','name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(StoreProductRequest::rules());

        try {
            $product = new Product();
            $product->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $product->image = $this->imageService->saveImage($request->file('image'), 'products', 540, 689);
            }

            $gallery = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $gallery[] = [
                        'full' => $this->imageService->saveImage($image, 'products', 540, 689),
                        'thumbnail' => $this->imageService->generateThumbnail($image, 'products', 'thumbnails', 104, 104),
                    ];
                }
            }

            $product->images = json_encode($gallery);

            $product->save();
            return redirect()->route('product.index')->withSuccess('Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create product. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit',[
            'product' => $product,
            'gallery' => json_decode($product->images,true) ?? [],
            'categories' => Category::select('id','name')->orderBy('name')->get(),
            'brands' => Brand::select('id','name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate(UpdateProductRequest::rules($product));

        try {
            $product->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $this->imageService->deleteImage($product->image, 'products');
                $product->image = $this->imageService->saveImage($request->file('image'), 'products', 540, 689);
            }

            $existingGallery = json_decode($product->images, true) ?? [];

            if ($request->has('deleted_images')) {
                foreach ($request->deleted_images as $deletedImage) {
                    foreach ($existingGallery as $key => $image) {
                        if ($image['full'] === $deletedImage) {
                            $this->imageService->deleteImage($image['full'], 'products');
                            $this->imageService->deleteImage($image['thumbnail'], 'products', 'thumbnails');
                            unset($existingGallery[$key]);
                        }
                    }
                }
                $existingGallery = array_values($existingGallery);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $existingGallery[] = [
                        'full' => $this->imageService->saveImage($image, 'products', 540, 689),
                        'thumbnail' => $this->imageService->generateThumbnail($image, 'products', 'thumbnails', 104, 104),
                    ];
                }
            }

            $product->images = json_encode($existingGallery);
            $product->save();

            return redirect()->route('product.index')->withSuccess('Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return back()->withError('Failed to update product. Please try again.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            $this->imageService->deleteImage($product->image, 'products');
            $this->imageService->deleteImages(json_decode($product->images), 'products', 'thumbnails');
            return redirect()->route('product.index')->withSuccess('Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete product. Please try again.');
        }
    }
}
