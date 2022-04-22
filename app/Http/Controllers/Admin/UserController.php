<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index()
    {
        return Inertia::render('Backend/Admin/User'); 
    }

    public function add(CreateUserRequest $request)
    {
        return $this->userServices->add(
            $request->input('username'),
            $request->input('email'),
            $request->input('password'),
            $request->input('name'),
            $request->input('status'),
            $request->input('role')
        );
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userServices->update(
            $request->input('role'),
            $request->input('id'),
            $request->input('email'),
            $request->input('password'),
            $request->input('name'),
        );
    }

    public function status($id)
    {
        return $this->userServices->status($id);
    }

    public function delete($id)
    {
        return $this->userServices->delete($id);
    }

    public function listing(Request $request)
    {
        $role = $request->input('role');
        $status = $request->input('status');

        $start = $request->input('start');
        $length = $request->input('length');
        $keyword = $request->input('search');
        $orderBy = $request->input('order_by');
        $orderType = $request->input('order_type');

        return $this->userServices->listing($role, $status, $keyword, $start, $length, $orderBy, $orderType);
    }

}
