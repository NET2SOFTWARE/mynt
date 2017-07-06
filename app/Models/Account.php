<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package App\Models
 */
class Account extends Model
{
    /**
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @var array
     */
    protected $fillable = ['number', 'mynt_id', 'account_type_id', 'limit_balance', 'limit_balance_transaction'];

    /**
     * @var array
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'limit_balance' => 'integer',
        'limit_balance_transaction' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function passbooks()
    {
        return $this->belongsToMany(Passbook::class, 'account_passbooks', 'account_id', 'passbook_id')
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_accounts', 'account_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_accounts', 'account_id', 'company_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_accounts', 'account_id', 'merchant_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'account_transactions', 'account_id', 'transaction_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_accounts', 'account_id', 'member_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_charge()
    {
        return $this->hasMany(MappingCharge::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_fee()
    {
        return $this->hasMany(MappingFee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_product()
    {
        return $this->hasMany(MappingProduct::class);
    }
}
