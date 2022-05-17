<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\UpdateAccountRequest;

class UpdateUserRequest extends UpdateAccountRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var User $user */
        $user = $this->user;
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->getKey())],
        ];
    }
}
