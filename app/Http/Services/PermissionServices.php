<?php

namespace App\Http\Services;

use App\Repositories\Backend\Admin\PermissionRepository;
use Illuminate\Http\Request;

class PermissionServices{
    private $permissionRepo;

    public function __construct(PermissionRepository $permissionRepo){
        $this->permissionRepo = $permissionRepo;
    }


    public function index()
    {
        return view('backend.admin.permission.index');
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

        $filteredRecords = $this->permissionRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->permissionRepo->listingSimple([], '', ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        return response()->json([
            'draw' => $draw,
            'data' => $this->permissionRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, false),
            'recordsFiltered' => $filteredRecords ? $filteredRecords : 0,
            'recordsTotal' => $totalRecords ? $totalRecords : 0,
        ]);
    }

    public function add(Request $request)
    {
        return response()->json([
            'code' => $this->permissionRepo->create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update(Request $request)
    {
        return response()->json([
            'code' => $this->permissionRepo->updateById(
                $request->input('id'),
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description')
                ]) ? SUCCESS_CODE : ERROR_CODE,
        ]);
    }

    public function delete($id)
    {
        return response()->json([
            'code' => $this->permissionRepo->deleteById($id) ? SUCCESS_CODE : ERROR_CODE,
        ]);
    }

    public function listingAll()
    {
        return response()->json([
            'data' => $this->permissionRepo->all()
        ]);
    }
}