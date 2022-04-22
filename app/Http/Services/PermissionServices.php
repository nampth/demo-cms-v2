<?php

namespace App\Http\Services;

use App\Repositories\Backend\Admin\PermissionRepository;
use Illuminate\Http\Request;

class PermissionServices
{
    private $permissionRepo;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }


    public function index()
    {
        return view('backend.admin.permission.index');
    }

    public function listing($start, $length, $keyword, $orderBy, $orderType)
    {
        $filteredRecords = $this->permissionRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        $totalRecords = $this->permissionRepo->listingSimple([], '', ['name', 'description'], $start, $length, $orderBy, $orderType, true);
        return response()->json([
            'data' => $this->permissionRepo->listingSimple([], $keyword, ['name', 'description'], $start, $length, $orderBy, $orderType, false),
            'recordsFiltered' => $filteredRecords ? $filteredRecords : 0,
            'recordsTotal' => $totalRecords ? $totalRecords : 0,
        ]);
    }

    public function add($name, $desc)
    {
        return response()->json([
            'code' => $this->permissionRepo->create([
                'name' => $name,
                'description' => $desc
            ]) ? SUCCESS_CODE : ERROR_CODE
        ]);
    }

    public function update($id, $name, $desc)
    {
        return response()->json([
            'code' => $this->permissionRepo->updateById(
                $id,
                [
                    'name' => $name,
                    'description' => $desc
                ]
            ) ? SUCCESS_CODE : ERROR_CODE,
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
