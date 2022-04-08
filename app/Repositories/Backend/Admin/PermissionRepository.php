<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/12/2021
 * Time: 2:42 PM
 */

namespace App\Repositories\Backend\Admin;


use App\Models\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        // TODO: Implement model() method.
        return Permission::class;
    }
}