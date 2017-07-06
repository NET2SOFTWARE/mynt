<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Children
 * @package App\Models
 */
class Children extends Model
{
    /**
     * @var string
     */
    protected $table = 'childrens';

    /**
     * @var array
     */
    protected $fillable = ['user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_childrens', 'children_id', 'user_id')
            ->withTimestamps();
    }
}
