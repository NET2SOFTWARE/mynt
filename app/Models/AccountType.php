<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountType
 * @package App\Models
 */
class AccountType extends Model
{
    /**
     * @var string
     */
    protected $table = 'account_types';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_slug($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getNameAttribute($value)
    {
        return $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_charge()
    {
        return $this->hasMany(MappingCharge::class);
    }
}
