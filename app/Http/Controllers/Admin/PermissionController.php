<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Services\PermissionServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    private $permissionServices;

    public function __construct(PermissionServices $permissionServices)
    {
        $this->permissionServices = $permissionServices;
    }

    public function index(){
        return Inertia::render('Backend/Admin/Permission'); 
    }

    public function listing(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        return $this->permissionServices->listing($start, $length, $keyword, $orderBy, $orderType);
    }

    public function listingAll(Request $request)
    {
        return $this->permissionServices->listingAll($request);
    }

    public function create(CreatePermissionRequest $request)
    {
        return $this->permissionServices->add(
            $request->input('name'),
            $request->input('description')
        );
    }

    public function update(UpdatePermissionRequest $request)
    {
        return $this->permissionServices->update(
            $request->input('id'),
            $request->input('name'),
            $request->input('description')
        );
    }

    public function deteleById($id)
    {
        return $this->permissionServices->delete($id);
    }
}
