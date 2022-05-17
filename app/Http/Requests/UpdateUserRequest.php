<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var User $user */
        $user = Auth::user();

        return
        [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->getKey())],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
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
            'password.min' => 'Le mot de passe doit faire minimum :min charactères'
        ];
    }
}
