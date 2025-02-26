<?php

namespace App\Http\Requests\V1\CouponRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'type' => ['required'],
            'value' => ['required', 'numeric'],
            'cart_value' => ['required', 'numeric'],
            'expiry_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
