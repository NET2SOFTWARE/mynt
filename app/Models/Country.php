<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App\Models
 */
class Country extends Model
{
    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = ['iso', 'name', 'currency'];

    /**
     * @param $value
     */
    public function setIsoAttribute($value)
    {
        $this->attributes['iso'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getIsoAttribute($value)
    {
        return strtoupper($value);
    }

    /**
     * @param $value
     */
    public function setCurrencyAttribute($value)
    {
        $this->attributes['currency'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getCurrencyAttribute($value)
    {
        return strtoupper($value);
    }

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
    public function state()
    {
        return $this->hasMany(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function city()
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
