<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 * @package App\Models
 */
class Bank extends Model
{
    /**
     * @var string
     */
    protected $table = 'banks';

    /**
     * @var array
     */
    protected $fillable = [
        'bank_code', 'bank_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_banks', 'member_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_banks', 'company_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_banks', 'merchant_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }
}
