<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pic
 * @package App\Models
 */
class Pic extends Model
{
    /**
     * @var string
     */
    protected $table = 'pics';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'position_id'];

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
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getEmailAttribute($value)
    {
        return $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_pics', 'pic_id', 'merchant_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'pic_locations', 'pic_id', 'location_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_pics', 'pic_id', 'company_id')
            ->withTimestamps();
    }
}
