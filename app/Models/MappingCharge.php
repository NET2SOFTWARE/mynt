<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MappingCharge
 * @package App\Models
 */
class MappingCharge extends Model
{
    /**
     * @var string
     */
    protected $table = 'mapping_charges';

    /**
     * @var array
     */
    protected $fillable = [
    	'service_id',
    	'charge_id',
    	'account_type_id',
    	'account_id',
    	'amount'
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
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_fee()
    {
        return $this->hasMany(MappingFee::class);
    }
}
