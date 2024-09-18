<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            'title' => 'required|string',
            'publisher' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|array',
            //'ISBN' => 'required|string',
            'book_description' => 'string|nullable',
            'publication_date' => 'date',
            'quantity' => 'int',
            'price' => 'int',
            'pages_number' => 'int',
            'chapters_number' => 'int',
            'download_size' => 'string',
            'book_image' => 'file|image|mimes:jpeg,png,jpg',
            'book_file' => 'file|required',

        ];
    }
}











////////////////////////
/// //        array_merge($customRules,
////        $locales = app()->getLocale(); // Get the current locale
////        $supportedLocales = config('app.languages'); // Get all supported locales
////
////        $customRules = [];
////        foreach ($supportedLocales as $locale) {
////            $customRules["category_{$locale}"] = [
////                Rule::exists('categories', 'id')->where(function ($query) use ($locale) {
////                    $query->where("name_{$locale}", $this->input("category_{$locale}"));
////                }),
////            ];
////            $customRules["author_{$locale}"] = [
////                Rule::exists('authors', 'id')->where(function ($query) use ($locale) {
////                    $query->where("name_{$locale}", $this->input("author_{$locale}"));
////                }),
////            ];
////            $customRules["publisher_{$locale}"] = [
////                Rule::exists('publishers', 'id')->where(function ($query) use ($locale) {
////                    $query->where("name_{$locale}", $this->input("publisher_{$locale}"));
////                }),
////            ];
////        }
