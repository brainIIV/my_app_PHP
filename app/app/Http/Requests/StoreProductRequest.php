<?php

namespace App\Http\Requests;

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
    public function rules(): array
    {
        return [
            'name' => 'required|distinct:ignore_case|string',
            'price' => 'required|integer',
            'is_deleted' => 'boolean',
            'is_published' => 'boolean',
            'categories' => 'array|min:2|max:10',
            'categories.*' => 'string|distinct:ignore_case|exists:categories,name'
        ];
    }
}
