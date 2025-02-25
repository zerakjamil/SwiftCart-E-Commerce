<?php

namespace App\Constants;

class ProductSortOptions
{
    public const ORDER_OPTIONS = [
        'newest' => ['created_at', 'DESC'],
        'oldest' => ['created_at', 'ASC'],
        'lowToHigh' => ['regular_price', 'ASC'],
        'highToLow' => ['regular_price', 'DESC'],
        'aToZ' => ['name', 'ASC'],
        'zToA' => ['name', 'DESC'],
        'discount' => ['sale_price', 'ASC'],
    ];
}
