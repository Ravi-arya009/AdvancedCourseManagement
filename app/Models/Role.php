<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    const ADMIN = 1;
    const INSTRUCTOR = 2;
    const STUDENT = 3;

    protected $fillable = ['role_name'];
}
