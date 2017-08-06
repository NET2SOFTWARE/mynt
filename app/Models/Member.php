<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Member
 * @package App\Models
 */
class Member extends Model
{
    /**
     * @var string
     */
    protected $table = 'members';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'image'
    ];

    /**
     * @param $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtolower($value);
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
     * @return string
     */
    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setPhoneAttribute($value)
    {
        $number = trim($value);

        if ('+' == substr($number, 0, 1))    $number = substr($number, 1);
        if ('6208' == substr($number, 0, 4)) $number = '62' . substr($number, 3);
        if ('08' == substr($number, 0, 2))   $number = '62' . substr($number, 1);
        if ('8' == substr($number, 0, 1))    $number = '62' . $number;

        $this->attributes['phone'] = $number;
        // $this->attributes['phone'] = str_is('0*', $value) ? '62'. substr($value, 1) : $value;
        // return $this->attributes['phone'] = '62'.strtolower($value);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_members', 'member_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'member_profiles', 'member_id', 'profile_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'member_locations', 'member_id', 'location_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'member_accounts', 'member_id', 'account_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function banks()
    {
        return $this->belongsToMany(Bank::class, 'member_banks', 'member_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'member_companies', 'member_id', 'company_id')
            ->withTimestamps();
    }

    /**
     * @return array
     */
    public function getAllUserIds()
    {
        $ids = [];

        foreach ($this->users() as $user) {
            $ids = $user->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllLocationsIds()
    {
        $ids = [];

        foreach ($this->locations() as $location) {
            $ids = $location->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllBankIds()
    {
        $ids = [];

        foreach ($this->banks() as $bank) {
            $ids = $bank->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllAccountIds()
    {
        $ids = [];

        foreach ($this->accounts() as $account) {
            $ids = $account->id;
        }

        return $ids;
    }

    public function isRegistered()
    {
        return (bool) ((int) $this->accounts()->first()['limit_balance'] > 1000000);
    }

    public function isPendingUpgrade()
    {
        $profile = $this->profiles()->first();

        if (count($profile) < 1) return false;

        return ($profile->status == 'pending') ? true : false;
    }

    public function isChildAccount()
    {
        return (bool) ((int) $this->accounts()->first()['limit_balance'] < 1000000);
    }

    public function isUnRegistered()
    {
        return (bool) ((int) $this->accounts()->first()['limit_balance'] == 1000000);
    }
}