<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(private User $model)
    {
    }

    public function allUserWithFilters(array $filters, string $order, string $direction) : LengthAwarePaginator
    {

        /** @var string|null $searchTitle */
        $searchTitle = $filters['searchName'] ?? null;

        /** @var string|null $adminValue */
        $adminValue = $filters['admin'] ?? null;

        $query = User::query()
                            ->orderBy($order, $direction)
                            ->when($searchTitle, function ($query, $searchTitle) {
                                $query->where('name', 'like', '%' . $searchTitle . '%');
                            })
                            ->when(isset($adminValue), function ($query) use ($adminValue) {
                                $query->where('admin', '=', $adminValue);
                            });
        
        return $query->paginate(5);
    }

    public function storeUser(array $data, string $password) : User
    {
        return $this->model->create(
            [
                'name' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($password),
            ]
        );
    }

    public function updateUser(array $data, User $user, bool $adminValue) : bool
    {
        $attributes = [
            'name' => $data['username'],
            'email' => $data['email'],
            'admin' => $adminValue,
        ];

        if (empty($data['password'])) {
            return $user->update($attributes);
        } else {
            $attributes['password'] = Hash::make($data['password']);
            return $user->update($attributes);
        }
    }

    public function deleteUser(User $user) : bool|null
    {
        return $user->delete();
    }

    public function getUsersOnComment(Collection $userId) : Collection
    {
        return $this->model->newQuery()->whereIn('id', $userId)->get();
    }

    public function countUser() : int
    {
        return $this->model->newQuery()->count();
    }
}
