<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ParentAccount extends Model
{
    /**
     * @var string
     */
    protected $table = 'parent_accounts';

    /**
     * @var array
     */
    protected $fillable = ['parent_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_parent_accounts', 'parent_account_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
