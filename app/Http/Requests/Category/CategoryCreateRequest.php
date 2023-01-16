<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'myfile' => 'nullable|file|max:1500|mimes:jpg,png',
            //'status' => 'nullable',
            'parent_id' => 'nullable'

            //'model-column-name{database-column}' => '...' 
        ];
    }
}
