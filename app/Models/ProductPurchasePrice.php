<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchasePrice extends Model
{
    protected $table = 'product_purchase_price';

    protected $fillable = [
    	'product_id',
    	'company_id',
    	'price',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product_sales_prices()
    {
        return $this->hasMany(ProductSalesPrice::class);
    }
}
