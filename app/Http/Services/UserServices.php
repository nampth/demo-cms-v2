<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Backend\Admin\UserRepository;
use Illuminate\Http\Request;

class UserServices
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function add($roleId, $username, $email, $password, $name, $status)
    {
        $role = Role::find($roleId);

        // validate for exist role
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role not found'
            ], 400);
        }

        return response()->json([
            'code' => $this->userRepo->add(
                $username,
                $email,
                $password,
                $name,
                $status,
                $roleId
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update($roleId, $id, $email, $password, $name)
    {
        $role = Role::find($roleId);
        // validate for exist role
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role not found'
            ], 400);
        }

        $result = $this->userRepo->edit(
            $id,
            $email,
            $password,
            $name,
            $roleId
        );
        return response()->json([
            'code' => $result ? SUCCESS_CODE : ERROR_CODE,
        ]);
    }

    public function status($id)
    {
        $user = User::find($id);
        // validate for exist user
        if (!$user) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'User not found'
            ], 400);
        }
        return response()->json([
            'code' => $this->userRepo->updateById($id, [
                'status' => $user->status == USER_STATUS_ACTIVE ? USER_STATUS_INACTIVE : USER_STATUS_ACTIVE
            ]) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }


    public function delete($id)
    {
        $user = User::find($id);
        // validate for exist user
        if (!$user) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'User not found'
            ], 400);
        }
        $user->roles()->detach();

        return response()->json([
            'code' => $user->delete() ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function listing($role, $status, $keyword, $start, $length, $orderBy, $orderType)
    {
        $filteredRecords = $this->userRepo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->userRepo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, true);

        return response()->json([
            'data' => $this->userRepo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, false),
            'recordsFiltered' => $filteredRecords ? $filteredRecords : 0,
            'recordsTotal' => $totalRecords ? $totalRecords : 0,
        ]);
    }
}
