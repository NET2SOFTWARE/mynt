<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * @package App\Models
 */
class Location extends Model
{
    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * @var array
     */
    protected $fillable = ['street', 'zip_code', 'city_id'];

    /**
     * @param $value
     */
    public function setStreetAttribute($value)
    {
        $this->attributes['street'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getStreetAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function city()
    {
        return $this->belongsToMany(City::class, 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_locations', 'location_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_locations', 'location_id', 'merchant_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_locations', 'location_id', 'company_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pics()
    {
        return $this->belongsToMany(Pic::class, 'pic_locations', 'location_id', 'pic_id')
            ->withTimestamps();
    }
}
