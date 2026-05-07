<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use App\Traits\HandlesControllerErrors;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    use HandlesControllerErrors;

    public function __construct(private RoleService $roleService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('can:roles.view', only: ['index']),
            new Middleware('can:roles.create', only: ['create', 'store']),
            new Middleware('can:roles.edit', only: ['edit', 'update']),
            new Middleware('can:roles.delete', only: ['destroy']),
            new Middleware('navigation', only: ['index', 'create', 'edit']),
        ];
    }

    public function index(IndexRoleRequest $request)
    {
        try {
            $roles = $this->roleService->getPaginated($request);

            return view('roles.index', compact('roles'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }

    public function create()
    {
        try {
            $allPermissions = $this->roleService->getAllPermissions();

            return view('roles.create', compact('allPermissions'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $this->roleService->create($request);

            return redirect()->route('roles.index')
                ->with('success', __('roles.success_create'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }

    public function edit(Role $role)
    {
        try {
            $allPermissions = $this->roleService->getAllPermissions();

            return view('roles.edit', compact('role', 'allPermissions'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $this->roleService->update($request, $role);

            return redirect()->route('roles.index')
                ->with('success', __('roles.success_update'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->delete($role);

            return redirect()->route('roles.index')
                ->with('success', __('roles.success_delete'));
        } catch (\Exception $e) {
            return $this->handleException($e, 'roles.index');
        }
    }
}
