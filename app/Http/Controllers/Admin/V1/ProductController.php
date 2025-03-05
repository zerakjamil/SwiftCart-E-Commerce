<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Requests\V1\ProductRequests\{StoreProductRequest,UpdateProductRequest};
use App\Http\Services\ImageService;
use App\Models\Admin\V1\{Brand,Category,Product,};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log,DB};

class ProductController extends Controller
{
    protected ImageService $imageService;
    protected CartService $cartService;

    public function __construct(ImageService $imageService = null, CartService $cartService = null)
    {
        $this->imageService = $imageService ?? new ImageService();
        $this->cartService = $cartService ?? new CartService();
    }

    public function index(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $products = Product::latest()->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = new Product();
            $product->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $product->image = $this->imageService->saveImage($request->file('image'), 'products', 540, 689);
            }

            $gallery = $this->processGalleryImages($request->file('images', []));
            $product->images = json_encode($gallery);

            $product->save();

            DB::commit();
            return redirect()->route('product.index')->withSuccess('Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        $gallery = $product->images ?? [];
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product.edit', compact('product', 'gallery', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $product->fillAttributes($request->validated());

            if ($request->hasFile('image')) {
                $this->imageService->deleteImage($product->image, 'products');
                $product->image = $this->imageService->saveImage($request->file('image'), 'products', 540, 689);
            }

            $existingGallery = $this->updateGallery($product, $request);
            $product->images = json_encode($existingGallery);

            $product->save();

            DB::commit();
            return redirect()->route('product.index')->withSuccess('Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed: ' . $e->getMessage());
            return back()->withError('Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $this->cartService->removeProductFromCart($product->id);
            $product->delete();
            $this->deleteProductImages($product);
            DB::commit();
            return redirect()->route('product.index')->withSuccess('Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete product. Please try again.');
        }
    }

    private function processGalleryImages(array $images): array
    {
        $gallery = [];
        foreach ($images as $image) {
            $gallery[] = [
                'full' => $this->imageService->saveImage($image, 'products', 540, 689),
                'thumbnail' => $this->imageService->generateThumbnail($image, 'products', 'thumbnails', 104, 104),
            ];
        }
        return $gallery;
    }

    private function updateGallery(Product $product, Request $request): array
    {
        $existingGallery = $product->images ?? [];

        if ($request->has('deleted_images')) {
            $existingGallery = $this->removeDeletedImages($existingGallery, $request->deleted_images);
        }

        if ($request->hasFile('images')) {
            $newImages = $this->processGalleryImages($request->file('images'));
            $existingGallery = array_merge($existingGallery, $newImages);
        }

        return $existingGallery;
    }

    private function removeDeletedImages(array $existingGallery, array $deletedImages): array
    {
        foreach ($deletedImages as $deletedImage) {
            $existingGallery = array_filter($existingGallery, function ($image) use ($deletedImage) {
                if ($image['full'] === $deletedImage) {
                    $this->imageService->deleteImage($image['full'], 'products');
                    $this->imageService->deleteImage($image['thumbnail'], 'products', 'thumbnails');
                    return false;
                }
                return true;
            });
        }
        return array_values($existingGallery);
    }

    private function deleteProductImages(Product $product): void
    {
        $this->imageService->deleteImage($product->image, 'products');
        $gallery = $product->images ?? [];
        foreach ($gallery as $image) {
            $this->imageService->deleteImage($image['full'], 'products');
            $this->imageService->deleteImage($image['thumbnail'], 'products', 'thumbnails');
        }
    }
}
