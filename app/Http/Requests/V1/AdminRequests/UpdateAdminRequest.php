<?php

namespace App\Http\Requests\V1\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
        'name' => ['sometimes', 'required', 'string', 'max:255'],
        'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:admins,email,' . $this->route('admin')->id],
        'old_password' => ['nullable', 'required_with:password'],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        'password_confirmation' => ['nullable', 'required_with:password'],
        ];
    }
}
