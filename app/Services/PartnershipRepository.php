<?php

namespace App\Services;

use App\Models\Partnership;
use App\Contracts\AbstractInterface;
use App\Contracts\PartnershipInterface;

/**
 * Class PartnershipRepository
 * @package App\Services
 */
class PartnershipRepository extends AbstractInterface implements PartnershipInterface
{
    /**
     * PartnershipRepository constructor.
     * @param Partnership $model
     */
    public function __construct(Partnership $model)
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
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ];
    }
}