<?php

namespace App\Filters;

use App\Constants\ProductSortOptions;
use App\Models\Admin\V1\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter
{
    protected $request;
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        $this->query = $query;

//        $this->applyCategory()
//             ->applyColor()
//             ->applySize()
//             ->applyBrand()
//             ->applyPriceRange()
//             ->applySort();

        $this->applyCategory()
             ->applyBrand()
             ->applyPriceRange()
             ->applySort();

        return $this->query;
    }

    protected function applyCategory(): self
    {
        if ($this->request->has('category')) {
            $this->query->category($this->request->category);
        }
        return $this;
    }

//    protected function applyColor(): self
//    {
//        if ($this->request->has('color')) {
//            $this->query->color($this->request->color);
//        }
//        return $this;
//    }

//    protected function applySize(): self
//    {
//        if ($this->request->has('size')) {
//            $this->query->size($this->request->size);
//        }
//        return $this;
//    }

    protected function applyBrand(): self
    {
        if ($this->request->has('brand')) {
            $this->query->brand($this->request->brand);
        }
        return $this;
    }

    protected function applyPriceRange(): self
    {
        if ($this->request->has('min_price') && $this->request->has('max_price')) {
            $this->query->priceRange($this->request->min_price, $this->request->max_price);
        }
        return $this;
    }

    protected function applySort(): self
    {
        $order = $this->request->query('order', 'latest');
        [$column, $direction] = ProductSortOptions::ORDER_OPTIONS[$order] ?? ['id', 'DESC'];
        $this->query->orderBy($column, $direction);
        return $this;
    }

    public function getSize(): int
    {
        return $this->request->query('size', 12);
    }

    public function getOrder(): string
    {
        return $this->request->query('order', 'latest');
    }
}
