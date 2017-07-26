<?php

namespace App;

use App\Models\Children;
use App\Models\Company;
use App\Models\LogLogin;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\Notification;
use App\Models\ParentAccount;
use App\Models\Remittance;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'isConfirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'isConfirmed' => 'boolean'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return (bool) $this->isConfirmed;
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
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_is('0*', $value) ? '62'. substr($value, 1) : $value;
    }

    /**
     * @param $value
     * @return string
     */
    public function getPhoneAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'user_id',
            'role_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'user_members', 'user_id', 'member_id')
            ->withTimestamps();
    }

    /**
     *
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'user_merchants', 'user_id', 'merchant_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'user_companies', 'user_id', 'company_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function log_logins()
    {
        return $this->belongsToMany(LogLogin::class, 'user_log_logins', 'user_id', 'log_login_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parentAccounts()
    {
        return $this->belongsToMany(ParentAccount::class, 'user_parent_accounts', 'user_id', 'parent_account_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentAccount()
    {
        return $this->hasMany(ParentAccount::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications', 'user_id', 'notification_id')
            ->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getAllRoleIds()
    {
        $ids = [];

        foreach ($this->roles() as $role) {
            $ids = $role->id;
        }

        return $ids;
    }

    /**
     * @return mixed
     */
    public function getAllMemberIds()
    {
        $ids = [];

        foreach ($this->members() as $member) {
            $ids = $member->id;
        }

        return $$ids;
    }

    /**
     * @return mixed
     */
    public function getAllMerchantIds()
    {
        $ids = [];

        foreach ($this->merchants() as $merchant) {
            $ids = $merchant->id;
        }

        return $$ids;
    }

    /**
     * @return mixed
     */
    public function getAllCompanyIds()
    {
        $ids = [];

        foreach ($this->companies() as $company) {
            $ids = $company->id;
        }

        return $$ids;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childrens()
    {
        return $this->belongsToMany(Children::class, 'user_childrens', 'user_id', 'children_id')
            ->withTimestamps();
    }

    /**
     * @return int
     */
    public function role()
    {
        return (int) $this->roles()->first()['id'];
    }

    public function isChildAccount()
    {
        return count($this->parentAccounts()) >= 1 ? true : false;
    }

    public function remittances()
    {
        return $this->belongsToMany(Remittance::class, 'user_remittances', 'user_id', 'remittance_id')
            ->withTimestamps();
    }
}
