<?php

namespace App\Repositories;

use App\Models\User;
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

        /** @var string|null $valuePublished */
        $valuePublished = $filters['value'] ?? null;


        $query = User::query()
                            ->orderBy($order, $direction)
                            ->when($searchTitle, function ($query, $searchTitle) {
                                $query->where('name', 'like', '%' . $searchTitle . '%');
                            })
                            ->when(!is_null($valuePublished), function ($query) use ($valuePublished, $order) {
                                $query->where($order, '=', $valuePublished);
                            });
        
        $users = $query->paginate(5);

        return $users;
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

    public function updateUser(array $data, array $params) : mixed
    {
        if (empty($params['password'])) {
            return $this->model->where('id', $params['user']->id)->update(
                [
                    'name' => $data['username'],
                    'email' => $data['email'],
                    'admin' => $params['adminValue'],
                ]
            );
        } else {
            return $this->model->where('id', $params['user']->id)->update(
                [
                    'name' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($params['password']),
                    'admin' => $params['adminValue'],
                ]
            );
        }
    }

    public function countUser() : int
    {
        return $this->model->newQuery()->count();
    }
}

?>