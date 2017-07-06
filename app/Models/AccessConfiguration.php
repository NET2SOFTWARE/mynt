<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessConfiguration extends Model
{
    /**
     * @var string
     */
    protected $table = 'access_configurations';

    /**
     * @var array
     */
    protected $fillable = ['access_name', 'access_action'];

    protected $casts = [
        'access_action' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_access_configurations', 'access_configuration_id', 'role_id')
            ->withPivot(['access_features'])
            ->withTimestamps();
    }
}
