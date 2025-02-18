<?php

namespace App\Http\Requests\V1\ProductRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:products,slug'],
            'SKU' => ['required', 'string', 'max:100'],
            'stock_status' => ['required', 'string', 'max:100'],
            'quantity' => ['required', 'integer'],
            'featured' => ['required', 'boolean'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'regular_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'short_description' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
