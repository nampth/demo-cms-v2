<?php 

namespace App\Traits\User;

use App\Models\User;

trait CreatedByUserTrait
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
