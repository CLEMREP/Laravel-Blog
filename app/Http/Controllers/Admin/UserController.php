<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request) : View
    {
        if (!is_null($request->get('order')) && !is_null($request->get('value'))) {
            $users = User::select('*')->where($request->get('order'), '=', $request->get('value'))->paginate(5);
        } else {
            if (!is_null($request->get('search_user'))) {
                $users = User::select('*')->where('name', 'like', '%' . $request->get('search_user') . '%')->paginate(5);
            } else {
                if (!is_null($request->get('order')) && !is_null($request->get('direction'))) {
                    $users = User::orderBy($request->get('order'), $request->get('direction'))->paginate(5);
                } else {
                    $users = User::orderBy('name', 'asc')->paginate(5);
                }
            }
        }
        
        return view('admin.users', ['title' => 'Liste des utilisateurs'], compact('users'));
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
            $user->admin = true;
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
        $request->validated();
        /** @var string $password */
        $password = $request->password;
        if (is_null($request->password)) {
            $user->update(
                [
                    'name' => $request->username,
                    'email' => $request->email,
                    'admin' => $request->get('admin', false)
                ]
            );
        } else {
            $user->update(
                [
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'admin' => $request->get('admin', false)
                ]
            );
        }



        return redirect('/dashboard/users');
    }

    public function destroy(User $user) : RedirectResponse
    {
        $user->delete();

        return redirect('/dashboard/users');
    }
}
