<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MappingFee
 * @package App\Models
 */
class MappingFee extends Model
{
    /**
     * @var string
     */
    protected $table = 'mapping_fees';

    /**
     * @var array
     */
    protected $fillable = [
    	'mapping_charge_id',
    	'account_id',
    	'amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapping_charge()
    {
        return $this->belongsTo(MappingCharge::class, 'mapping_charge_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
