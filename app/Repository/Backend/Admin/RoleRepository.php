<?php

namespace App\Repositories\Backend\Admin;


use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        // TODO: Implement model() method.
        return Role::class;
    }

    public function add($name, $description, $redirect, $permission)
    {
        $role = new Role();
        $role->name = $name;
        $role->description = $description;
        $role->default_redirect = $redirect;
        if (!$role->save()) {
            return false;
        }
        $role->permissions()->attach($permission);
        return true;
    }

    public function update($id, $role, $name, $description, $redirect, $permission)
    {
        $this->updateById(
            $id,
            [
                'name' => $name,
                'description' => $description,
                'default_redirect' => $redirect,
            ]
        );

        $role->permissions()->detach();
        $role->permissions()->attach($permission);
        return true;
    }
}
