<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'content' => 'required',
            'published' => 'required|boolean',
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Vous devez insérer un titre.',
            'title.unique' => 'Le titre est déjà existant.',
            'title.max' => 'Le titre doit faire un maximum :max caractères.',
            'content.required' => 'Vous devez insérer un contenu.',
            'picture.max' => 'L\'image doit faire maximum :max ko'
        ];
    }
}
