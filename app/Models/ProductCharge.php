<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCharge extends Model
{
    protected $table = 'product_charge';

    protected $fillable = [
    	'product_sales_price_id',
    	'charge',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_sales()
    {
        return $this->belongsTo(ProductSales::class, 'product_sales_price_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product_fees()
    {
        return $this->hasMany(ProductFee::class);
    }
}
