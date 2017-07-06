<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    /**
     * @var string
     */
    protected $table = 'log_logins';

    /**
     * @var array
     */
    protected $fillable = ['ip_address'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_log_logins', 'log_login_id', 'user_id')
            ->withTimestamps();
    }
}
