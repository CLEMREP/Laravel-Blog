<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index() : View
    {
        $users = User::orderBy('created_at')->paginate(4);
        return view('admin.users', ['title' => 'Utilisateurs'], compact('users'));
    }

    public function create() : View
    {
        return view('admin.create_user');
    }

    public function store(StoreUserRequest $request) : RedirectResponse
    {
        $data = $request->validated();
        /** @var string $password */
        $password = $request->password;
        
        $user = User::create(
            [
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($password),
            ]
        );

        if ($request->has('admin')) {
            $user->admin = 1;
            $user->save();
        }

        return redirect(route('admin.users.index'));
    }

    public function edit(User $user) : View
    {
        return view('admin.edit_user', ['title' => 'Edit' . ' ' . $user->email, 'user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user) : RedirectResponse
    {
        $data = $request->validated();
        /** @var string $password */
        $password = $request->password;
        
        if (!($request->has('password'))) {
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


        if ($request->has('admin')) {
            $user->admin = 1;
            $user->save();
        }

        return redirect('/dashboard/users');
    }

    public function destroy(User $user) : RedirectResponse
    {
        $user->delete();

        return redirect('/dashboard/users');
    }
}
