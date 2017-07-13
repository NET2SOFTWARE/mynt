<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'mapping_product_tax_fee';

    /**
     * @var array
     */
    protected $fillable = [
    	'product_id',
    	'account_id',
    	'tax',
    	'fee',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
