<?php

namespace App\Http\Requests\V1\OrderRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'phone' => ['required' , 'numeric' , 'digits:11'],
            'zip' => ['required' , 'numeric' , 'digits:5'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'locality' => ['required'],
            'landmark' => ['required'],
        ];
    }
}
