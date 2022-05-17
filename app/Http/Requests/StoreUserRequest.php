<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return             [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required']
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
            'username.required' => 'Vous devez insérer un username.',
            'email.unique' => 'L\'e-mail est déjà existante.',
            'email.required' => 'Vous dever insérer une e-mail',
            'email.email' => 'L\'e-mail doit être au bon format',
            'password.required' => 'Vous devez insérer un mot de passe',
            'password.confirmed' => 'Les mots de passes doivent être similaires.',
            'password_confirmation.required' => 'Vous devez confirmer le mot de passe',
            'password.min' => 'Le mot de passe doit faire minimum :min charactères'
        ];
    }
}
