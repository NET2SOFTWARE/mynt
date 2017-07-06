<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Passbook
 * @package App\Models
 */
class Passbook extends Model
{
    /**
     * @var string
     */
    protected $table = 'passbooks';

    /**
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'credit',
        'debit',
        'balance'
    ];

    /**
     * @return int
     */
    public function getLastBalance()
    {
        return (int) $this
            ->orderBy('created_at', 'desc')
            ->first(['balance']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_passbooks', 'passbook_id', 'account_id')
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
