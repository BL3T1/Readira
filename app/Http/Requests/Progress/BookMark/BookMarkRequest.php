<?php

namespace App\Http\Requests\Progress\BookMark;

use Illuminate\Foundation\Http\FormRequest;

class   BookMarkRequest extends FormRequest
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
            'book_id' => 'required|int',
            'page_number' => 'required|int',
            'book_mark' => 'required|string',
            'note' => 'required|string',
        ];
    }
}
