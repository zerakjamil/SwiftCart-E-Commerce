<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Slide;
use Illuminate\Support\Facades\{Auth,DB,Hash};
use Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Auth\Authenticatable;
class SlideService extends Service
{
    public function __construct(Slide $slide)
    {
        parent::__construct($slide);
    }

    public function createSlide($data)
    {
        return DB::transaction(function () use ($data) {
            $slide = Slide::create($data);
            return $slide;
        });
    }

    public function updateSlide(Slide $slide, $data): void
    {
        DB::transaction(function () use ($slide, $data) {
            $slide->fillAttributes($data);
            $slide->save();
        });
    }

    public function deleteSlide(Slide $slide): void
    {
        DB::transaction(fn() => $slide->delete());
    }

    public function getFilteredSlides(array $filters = [], array $columns = ['*'], int $perPage = 10)
    {
        $query = Slide::query();

        if (isset($filters['name']) && !empty($filters['name'])) {
            $search = $filters['name'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        if ($columns !== ['*']) {
            $query->select($columns);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }
}
