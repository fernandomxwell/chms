<?php

namespace App\Services;

use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserCredentials;
use Illuminate\Support\Str;

class UserService
{
    public function getPaginatedUsers(IndexUserRequest $request)
    {
        $validatedData = $request->validated();

        return User::searchBy($validatedData)
            ->with('role:id,name')
            ->select([
                'id',
                'role_id',
                'name',
                'email',
                'created_at',
            ])
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();
    }

    public function getRoles()
    {
        return Role::orderBy('name')->get(['id', 'name']);
    }

    public function create(StoreUserRequest $request): User
    {
        $data = $request->validated();
        $plainPassword = Str::password(12);
        $data['password'] = $plainPassword;

        $user = User::create($data);
        $user->notify(new NewUserCredentials($plainPassword));

        return $user;
    }

    public function delete(int $id): void
    {
        User::findOrFail($id, ['id'])->delete();
    }
}
