<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountRepository
{
    public function __construct(private User $model)
    {
    }

    public function updateAccount(array $data, array $params) : mixed
    {
        if (is_null($params['password'])) {
            return $this->model->newQuery()->where('id', $params['user']->id)->update(
                [
                    'name' => $data['username'],
                    'email' => $data['email'],
                ]
            );
        } else {
            return $this->model->newQuery()->where('id', $params['user']->id)->update(
                [
                    'name' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($params['password']),
                ]
            );
        }
    }
}
