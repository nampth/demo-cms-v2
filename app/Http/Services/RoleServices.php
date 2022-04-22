<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Repositories\Backend\Admin\RoleRepository;
use Illuminate\Http\Request;

class RoleServices
{
    private $roleRepo;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function listing($start, $length, $keyword, $orderBy, $orderType)
    {
        $filteredRecords = $this->roleRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->roleRepo->listingSimple([], '', ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        return response()->json([
            'data' => $this->roleRepo->listingSimple(['permissions'], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, false),
            'recordsFiltered' => $filteredRecords ? $filteredRecords : 0,
            'recordsTotal' => $totalRecords ? $totalRecords : 0,
        ]);
    }

    public function listingAll()
    {
        return response()->json([
            'data' => $this->roleRepo->all()
        ]);
    }

    public function add(
        $name,
        $desc,
        $redirect,
        $permissions
    ) {
        return response()->json([
            'code' => $this->roleRepo->add(
                $name,
                $desc,
                $redirect,
                $permissions
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update($id, $name, $desc, $redirect, $permissions)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role is not valid'
            ], 400);
        }

        return response()->json([
            'code' => $this->roleRepo->update(
                $id,
                $role,
                $name,
                $desc,
                $redirect,
                $permissions
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function delete($id)
    {

        $role = Role::find($id);
        if (!$role || $role->name == 'admin') {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role is not valid'
            ], 400);
        }
        $role->permissions()->detach();
        return response()->json([
            'code' => $role->delete() ? SUCCESS_CODE :  ERROR_CODE
        ]);
    }
}
