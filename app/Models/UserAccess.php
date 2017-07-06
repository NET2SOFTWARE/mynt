<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $table = 'user_accesses';

    protected $fillable = [
        'user_id', 'ip', 'login_at'
    ];
}
