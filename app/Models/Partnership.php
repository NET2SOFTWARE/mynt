<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Partnership
 * @package App\Models
 */
class Partnership extends Model
{
    /**
     * @var string
     */
    protected $table = 'partnerships';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];

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
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_partnerships', 'partnership_id', 'company_id')
            ->withTimestamps();
    }
}
