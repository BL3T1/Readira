<?php

namespace App\Http\Requests\Books;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'book_description' => 'nullable|string',
            'quantity' => 'nullable|int',
            'price' => 'nullable|int',
            'book_image' => 'nullable|string',
        ];
    }
}
