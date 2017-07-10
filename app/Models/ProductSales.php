<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSales extends Model
{
    protected $table = 'product_sales_price';

    protected $fillable = [
    	'product_purchase_price_id',
    	'merchant_id',
    	'price',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_purchase()
    {
        return $this->belongsTo(ProductPurchase::class, 'product_purchase_price_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchants()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_tax()
    {
        return $this->hasOne(ProductTax::class, 'product_sales_price_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_charge()
    {
        return $this->hasOne(ProductCharge::class, 'product_sales_price_id');
    }
}
