<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * @package App\Models
 */
class State extends Model
{
    /**
     * @var string
     */
    protected $table = 'states';

    /**
     * @var array
     */
    protected $fillable = ['name', 'country_id'];

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
    public function city()
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
