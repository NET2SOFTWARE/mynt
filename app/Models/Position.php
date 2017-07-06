<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Position
 * @package App\Models
 */
class Position extends Model
{
    /**
     * @var string
     */
    protected $table = 'positions';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pic()
    {
        return $this->hasMany(Pic::class);
    }
}
