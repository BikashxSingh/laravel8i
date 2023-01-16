<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
        // dd($_POST);
        return [
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'category_id' => 'nullable',
            'pImage' => 'nullable|file|max:1500|mimes:jpg,png',
            'price' => 'required',
            // 'spec.title.*' => 'nullable',
            // 'spec.specification.*' => 'nullable'
            'spec' => 'nullable',
            'spec.*' => 'nullable'

        ];
    }
}
