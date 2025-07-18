<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            "name"        => ['required', "unique:products,name,$id"],
            "category_id" => ['required', 'integer'],
            "sku"         => ['required'],
            "price"       => ['required', 'integer'],
            'stock'       => ['nullable', 'integer'],
            'discount'    => ['nullable', 'integer'],
            "image"       => [$this->method() == "POST" ? 'required' : 'nullable', 'image'],
        ];
    }
}
