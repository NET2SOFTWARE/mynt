<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App\Models
 */
class Transaction extends Model
{
    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var array
     */
    protected $fillable = [
        'trx_id',
        'service_id',
        'product_id',
        'sender_account_code',
        'receiver_account_code',
        'terminal',
        'amount',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status_badge',
    ];

    protected $casts = [
        'amount'    => 'integer',
        'status'    => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_transactions', 'transaction_id', 'account_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passbook()
    {
        return $this->hasMany(Passbook::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function global_passbooks()
    {
        return $this->belongsToMany(GlobalPassbook::class, 'passbook_global_transactions', 'transaction_id', 'global_passbook_id')
            ->withTimestamps();
    }
//
//    /**
//     * Get amount in Rupiah format
//     *
//     * @param  int $amount
//     * @return string
//     */
//    public function getAmountAttribute(int $amount)
//    {
//        return $this->attributes['amount'] = sprintf('Rp %s', number_format($amount, 0));
//    }

    /**
     * Get transaction status in bootstrap badge format
     * 
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == TRUE 
            ? '<span class="badge badge-success small-caps">success</span>'
            : '<span class="badge badge-danger small-caps">failed</span>';
    }
}
