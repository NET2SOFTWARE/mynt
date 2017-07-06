<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Identity
 * @package App\Models
 */
class Identity extends Model
{
    /**
     * @var string
     */
    protected $table = 'identities';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}
