<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'category_id' => 'nullable',
            'pImage' => 'nullable|file|max:1500|mimes:jpg,png',
            'price' => 'required',
            'status' => 'nullable|in:Active,Inactive',
            'spec.title.*' => 'nullable',
            'spec.specification.*' => 'nullable',
            'deleted_ids' => 'nullable|array'
        ];
    }
}
