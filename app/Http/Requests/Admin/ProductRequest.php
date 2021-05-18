<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' =>  'required|max:255',
            'users_id' => 'required|exists:users,id',
            'top_categories_id' => 'required|exists:top_categories,id',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'weight' => 'required|integer',
            'profit_sharing' => 'integer',
            'description' => 'required'
        ];
    }
}
