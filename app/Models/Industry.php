<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Industry
 * @package App\Models
 */
class Industry extends Model
{
    /**
     * @var string
     */
    protected $table = 'industries';

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
    public function company()
    {
        return $this->hasMany(Company::class);
    }
}
