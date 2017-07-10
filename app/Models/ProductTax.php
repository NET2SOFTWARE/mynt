<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    protected $table = 'product_tax';

    protected $fillable = [
    	'product_sales_price_id',
    	'tax',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_sales()
    {
        return $this->belongsTo(ProductSales::class, 'product_sales_price_id');
    }
}
