<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFee extends Model
{
    protected $table = 'product_charge_fees';

    protected $fillable = [
    	'product_charge_id',
    	'account_id',
    	'fee',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_charge()
    {
        return $this->belongsTo(ProductCharge::class, 'product_charge_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
