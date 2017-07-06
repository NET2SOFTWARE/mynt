<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = ['device', 'number'];

    /**
     * @var array
     */
    protected $casts = [
        'device' => 'string',
        'number' => 'integer'
    ];

    /**
     * @param $value
     */
    public function setDeviceAttribute($value)
    {
        $this->attributes['device'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getDeviceAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_contacts', 'contact_id', 'merchant_id')
            ->withTimestamps();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_contacts', 'contact_id', 'company_id')
            ->withTimestamps();
    }
}
