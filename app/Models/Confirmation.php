<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $primaryKey = 'user_id';

    protected $table = 'confirmations';

    protected $fillable = ['user_id', 'token', 'created_at'];
}
