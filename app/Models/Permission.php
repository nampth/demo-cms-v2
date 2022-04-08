<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i:s d/m/Y');
    }
}
