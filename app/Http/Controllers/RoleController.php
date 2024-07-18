<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseController
{

    public function index(): JsonResponse
    {
        $roles = Role::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($roles, "Roles Retrieved Successfully");
    }


    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = Role::query()->create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return $this->buildSuccessResponse($role, "New Role Created Successfully");
    }


    public function show(Role $role): JsonResponse
    {
        return $this->buildSuccessResponse($role, "Role Retrieved Successfully");
    }


    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $role = $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return $this->buildSuccessResponse($role, "Role Updated Successfully");
    }


    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return $this->buildSuccessResponse(null, 'Role deleted successfully');
    }
}
