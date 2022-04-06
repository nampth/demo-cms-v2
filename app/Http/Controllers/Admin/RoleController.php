<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Services\RoleServices;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleServices;

    public function __construct(RoleServices $roleServices)
    {
        $this->roleServices = $roleServices;
    }

    public function index()
    {
        return view('backend.admin.role.index');
    }

    public function add(CreateRoleRequest $request)
    {
        return $this->roleServices->add($request);
    }

    public function update(UpdateRoleRequest $request)
    {
        return $this->roleServices->update($request);
    }
    
    public function delete($id)
    {
        return $this->roleServices->delete($id);
    }

    public function listing(Request $request)
    {
        return $this->roleServices->listing($request);
    }

    public function listingAll(Request $request)
    {
        return $this->roleServices->listingAll();
    }

}
