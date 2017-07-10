<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSalesPrice extends Model
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
    public function product_purchase_prices()
    {
        return $this->belongsTo(ProductPurchasePrice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchants()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_tax()
    {
        return $this->hasOne(ProductTax::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_charge()
    {
        return $this->hasOne(ProductCharge::class);
    }
}
