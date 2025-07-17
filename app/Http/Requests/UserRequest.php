<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route("id");
        return [
            "name"     => ["required","string"],
            "email"    => ["required","string","email", "unique:users,email,$id"],
            "phone"    => ["required", "string", "min:11", "max:11", "unique:users,phone,$id"],
            'password' => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:6'],
            "image"    => ["nullable","image"]
        ];
    }
}
