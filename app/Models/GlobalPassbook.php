<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GlobalPassbook
 * @package App\Models
 */
class GlobalPassbook extends Model
{
    /**
     * @var string
     */
    protected $table = 'global_passbooks';

    /**
     * @var array
     */
    protected $fillable = [
        'debit', 'credit', 'balance'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'passbook_global_transactions', 'passbook_global_id', 'transaction_id')
            ->withTimestamps();
    }
}
