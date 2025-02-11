<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequests\StoreProductRequest;
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
