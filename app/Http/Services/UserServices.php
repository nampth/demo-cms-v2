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

    public function add(Request $request)
    {

        $roleId = $request->input('role');
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
                $request->input('username'),
                $request->input('email'),
                $request->input('password'),
                $request->input('name'),
                $request->input('status'),
                $role
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update(Request $request)
    {
        $roleId = $request->input('role');
        $role = Role::find($roleId);
        // validate for exist role
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role not found'
            ], 400);
        }

        $result = $this->userRepo->edit(
            $request->input('id'),
            $request->input('email'),
            $request->input('password'),
            $request->input('name'),
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
        return $user->delete();

        return response()->json([
            'code' => $user->delete() ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function listing(Request $request){
        $role = $request->input('role');
        $status = $request->input('status');

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $columns = $request->input('columns');

        $search = $request->input('search');
        $keyword = $search['value'];

        $order = $request->input('order');
        $orderBy = $columns[$order[0]['column']]['data'];
        $orderType = $order[0]['dir'];

        if ($orderBy == '') $orderBy = 'updated_at';

        $filteredRecords = $this->repo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->repo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, true);

        return response()->json([
            'draw' => $draw,
            'data' => $this->repo->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType, false),
            'recordsFiltered' => $filteredRecords ? $filteredRecords : 0,
            'recordsTotal' => $totalRecords ? $totalRecords : 0,
        ]);
    }
}
