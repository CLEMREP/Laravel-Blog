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
        /** @var string $order */
        $order = $request->get('order', 'name');

        /** @var string $direction */
        $direction = $request->get('direction', 'asc');

        /** @var string $searchName */
        $searchName = $request->get('search_title');

        /** @var string $valueRole */
        $valueAdmin = $request->get('value');

        $query = User::query()
                            ->orderBy($order, $direction)
                            ->when($searchName, function ($query, $searchName) {
                                $query->where('name', 'like', '%' . $searchName . '%');
                            })
                            ->when(!is_null($valueAdmin), function($query) use($valueAdmin, $order){
                                $query->where($order, '=', $valueAdmin);
                            });
        
        $users = $query->paginate(5);
        
        return view('admin.users',
        [
            'title' => 'Liste des utilisateurs',
            'filters' =>
            [
                ['title' => 'Alphabétique (Asc)', 'order' => 'name', 'direction' => 'asc'],
                ['title' => 'Alphabétique (Desc)', 'order' => 'name', 'direction' => 'desc'],
                ['title' => 'Date de création (Asc)', 'order' => 'created_at', 'direction' => 'asc'],
                ['title' => 'Date de création (Desc)', 'order' => 'created_at', 'direction' => 'desc'],
            ],
        ], compact('users'));
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
