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

    public function listing(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $columns = $request->input('columns');

        $search = $request->input('search');
        $keyword = $search['value'];

        $order = $request->input('order');
        $orderBy = $columns[$order[0]['column']]['data'];
        $orderType = $order[0]['dir'];

        $filteredRecords = $this->roleRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->roleRepo->listingSimple([], '', ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        return response()->json([
            'draw' => $draw,
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

    public function add(Request $request)
    {
        return response()->json([
            'code' => $this->roleRepo->add(
                $request->input('name'),
                $request->input('description'),
                $request->input('default_redirect'),
                $request->input('permissions')
            ) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update(Request $request)
    {
        $role = Role::find($request->input('id'));
        if (!$role) {
            return response()->json([
                'code' => ERROR_CODE,
                'msg' => 'Role is not valid'
            ], 400);
        }

        return response()->json([
            'code' => $this->roleRepo->update(
                $request->input('id'),
                $role,
                $request->input('name'),
                $request->input('description'),
                $request->input('default_redirect'),
                $request->input('permissions')
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
