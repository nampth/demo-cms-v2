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
        return $this->permissionServices->listing($request);
    }

    public function listingAll(Request $request)
    {
        return $this->permissionServices->listingAll($request);
    }

    public function add(CreatePermissionRequest $request)
    {
        return $this->permissionServices->add($request);
    }

    public function update(UpdatePermissionRequest $request)
    {
        return $this->permissionServices->update($request);
    }
    public function detele($id)
    {
        return $this->permissionServices->delete($id);
    }
}
