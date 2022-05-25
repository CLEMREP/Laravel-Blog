<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountRepository
{
    public function __construct()
    {
    }

    public function updateAccount(array $data, User $user) : mixed
    {
        $attributes = [
            'name' => $data['username'],
            'email' => $data['email'],
        ];

        if (empty($data['password'])) {
            return $user->update($attributes);
        } else {
            $attributes['password'] = Hash::make($data['password']);
            return $user->update($attributes);
        }
    }
}
