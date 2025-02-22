<?php

namespace App\Http\Requests\V1\ProductRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId),
            ],
            'short_description' => ['required','string'],
            'description' => ['required','string'],
            'regular_price' => ['required','numeric'],
            'sale_price' => ['nullable','numeric'],
            'SKU' => ['required','max:255'],
            'quantity' => ['required','numeric'],
            'featured' => ['required','boolean'],
            'stock_status' => ['required','in:instock,outofstock'],
            'category_id' => ['required','exists:categories,id'],
            'brand_id' => ['required','exists:brands,id'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];
    }
}
