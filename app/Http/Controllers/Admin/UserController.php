<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index()
    {
        return view('backend.admin.user.index');
    }

    public function add(CreateUserRequest $request)
    {
        return $this->userServices->add($request);
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userServices->update($request);
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
        return $this->userServices->listing($request);
    }

}
