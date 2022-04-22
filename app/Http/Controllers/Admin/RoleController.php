<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Services\RoleServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    private $roleServices;

    public function __construct(RoleServices $roleServices)
    {
        $this->roleServices = $roleServices;
    }

    public function index()
    {
        return Inertia::render('Backend/Admin/Role');
    }

    public function add(CreateRoleRequest $request)
    {

        return $this->roleServices->add(
            $request->input('name'),
            $request->input('description'),
            $request->input('default_redirect'),
            $request->input('permissions')
        );
    }

    public function update(UpdateRoleRequest $request)
    {
        return $this->roleServices->update(
            $request->input('id'),
            $request->input('name'),
            $request->input('description'),
            $request->input('default_redirect'),
            $request->input('permissions')
        );
    }

    public function deleteById($id)
    {
        return $this->roleServices->delete($id);
    }

    public function listing(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        return $this->roleServices->listing($start, $length, $keyword, $orderBy, $orderType);
    }

    public function listingAll(Request $request)
    {
        return $this->roleServices->listingAll();
    }
}
