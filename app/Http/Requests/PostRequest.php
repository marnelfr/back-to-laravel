<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'slug' => ['required', Rule::unique('posts', 'slug')],
            'thumbnail' =>'required|image',
            'excerpt' => 'required|min:3',
            'body' => 'required|min:3',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
