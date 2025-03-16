<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\V1\SlideRequests\{StoreSlideRequest,UpdateSlideRequest};
use App\Http\Services\{SlideService,ImageService};
use App\Models\Admin\V1\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    protected SlideService $slideService;
    protected ImageService $imageService;

    public function __construct(SlideService $slideService, ImageService $imageService)
    {
        $this->slideService = $slideService;
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $columns = ['id', 'image', 'tagline', 'title', 'subtitle', 'link'];
        $slides = $this->slideService->getFilteredSlides($filters, $columns);

        return view('admin.slide.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slide.create');
    }

    public function store(StoreSlideRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $this->imageService->saveSliderImage(
                    $request->file('image')
                );
            }

            $slide = $this->slideService->createSlide($data);

            return redirect()->route('slide.index')->with('success', 'Slide created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating slide: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Slide $slide)
    {
        return view('admin.slide.show', compact('slide'));
    }

    public function edit(Slide $slide)
    {
        return view('admin.slide.edit', compact('slide'));
    }

    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($slide->image) {
                    $this->imageService->deleteImage($slide->image, 'slides');
                }

                $data['image'] = $this->imageService->saveSliderImage(
                    $request->file('image')
                );
            }

            $this->slideService->updateSlide($slide, $data);

            return redirect()->route('slide.index')->with('success', 'Slide updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating slide: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Slide $slide)
    {
        try {
            if ($slide->image) {
                $this->imageService->deleteImage($slide->image, 'slides');
            }

            $this->slideService->deleteSlide($slide);

            return redirect()->route('admin.slide.index')->with('success', 'Slide deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting slide: ' . $e->getMessage());
        }
    }
}
