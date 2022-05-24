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
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function index(Request $request) : View
    {
        /** @var string $order */
        $order = $request->get('order', 'name');

        /** @var string $direction */
        $direction = $request->get('direction', 'asc');

        $filters = $request->only(['searchName', 'value']);

        $users = $this->userRepository->allUserWithFilters($filters, $order, $direction);
        
        return view(
            'admin.users',
            [
            'title' => 'Liste des utilisateurs',
            'filters' =>
            [
                ['title' => 'Alphabétique (Asc)', 'order' => 'name', 'direction' => 'asc'],
                ['title' => 'Alphabétique (Desc)', 'order' => 'name', 'direction' => 'desc'],
                ['title' => 'Date de création (Asc)', 'order' => 'created_at', 'direction' => 'asc'],
                ['title' => 'Date de création (Desc)', 'order' => 'created_at', 'direction' => 'desc'],
            ],
            ],
            compact('users')
        );
    }
    

    public function create() : View
    {
        return view('admin.create_user');
    }

    public function store(StoreUserRequest $request) : RedirectResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        /** @var string $password */
        $password = $request->password;
        
        $user = $this->userRepository->storeUser($validated, $password);

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
        /** @var array $validated */
        $validated = $request->validated();

        /** @var string $password */
        $password = $request->password ?? '';

        /** @var bool $adminValue */
        $adminValue = $request->get('admin', false);

        /** @var array $params */
        $params = ['user' => $user, 'password' => $password, 'adminValue' => $adminValue];

        $this->userRepository->updateUser($validated, $params);

        return redirect('/dashboard/users');
    }

    public function destroy(User $user) : RedirectResponse
    {
        $this->userRepository->deleteUser($user);

        return redirect('/dashboard/users');
    }
}
