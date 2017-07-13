<?php

namespace App\Services;

use App\Models\Product;
use App\Contracts\ProductInterface;
use App\Contracts\AbstractInterface;

/**
 * Class ProductRepository
 * @package App\Services
 */
class ProductRepository extends AbstractInterface implements ProductInterface
{

    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'name'          => $attributes['name'],
            // 'price'         => $attributes['price'],
            // 'photo'         => $attributes['photo'],
            'description'   => $attributes['description']
        ];
    }
}