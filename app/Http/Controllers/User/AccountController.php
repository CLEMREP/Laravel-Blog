<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateUserRequest;

class AccountController extends Controller
{
    public function edit() : View
    {
        return view('admin.account', ['title' => 'Mon compte', 'user' => Auth::user()]);
    }

    public function update(UpdateUserRequest $request) : RedirectResponse
    {
        $request->validated();
        
        /** @var User $user */
        $user = Auth::user();

        /** @var string $password */
        $password = $request->password;

        if (is_null($request->password)) {
            $user->update(
                [
                    'name' => $request->username,
                    'email' => $request->email,
                ]
            );
        } else {
            $user->update(
                [
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                ]
            );
        }

        return redirect(route('admin.account.edit'));
    }
}
