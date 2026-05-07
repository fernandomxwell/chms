<?php

namespace App\Services;

use App\Http\Requests\IndexRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Menu;
use App\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::orderBy('name')->get(['id', 'name']);
    }

    public function getPaginated(IndexRoleRequest $request)
    {
        return Role::searchBy($request->validated())
            ->orderBy('name')
            ->paginate()
            ->withQueryString();
    }

    public function create(StoreRoleRequest $request): Role
    {
        $data = $request->validated();
        $data['permissions'] = $data['permissions'] ?? [];

        return Role::create($data);
    }

    public function update(UpdateRoleRequest $request, Role $role): void
    {
        $data = $request->validated();
        $data['permissions'] = $data['permissions'] ?? [];

        $role->update($data);
    }

    public function delete(Role $role): void
    {
        $role->users()->update(['role_id' => null]);
        $role->delete();
    }

    public function addPermissions(string $roleName, array $actions): void
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        $existing = $role->permissions ?? [];
        $merged = array_unique(array_merge($existing, $actions));

        $role->update(['permissions' => array_values($merged)]);
    }

    public function getAllPermissions(): array
    {
        $parents = Menu::parent()
            ->with(['children' => fn($q) => $q->orderBy('order')])
            ->orderBy('order')
            ->get(['id', 'name', 'link', 'actions', 'order']);

        $groups = [];

        foreach ($parents as $parent) {
            if (!empty($parent->actions)) {
                $groups[] = [
                    'label' => $parent->translated_name,
                    'permissions' => collect($parent->actions)->sort()->values()->toArray(),
                ];
            }

            foreach ($parent->children as $child) {
                if (!empty($child->actions)) {
                    $groups[] = [
                        'label' => $child->translated_name,
                        'permissions' => collect($child->actions)->sort()->values()->toArray(),
                    ];
                }
            }
        }

        return $groups;
    }
}
