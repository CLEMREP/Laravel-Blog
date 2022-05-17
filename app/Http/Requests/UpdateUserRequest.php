<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Http\Requests\UpdateAccountRequest;

class UpdateUserRequest extends UpdateAccountRequest
{
    protected function getRequestUser(): User
    {
        /** @var User $user */
        $user = $this->user;

        return $user;
    }
}
