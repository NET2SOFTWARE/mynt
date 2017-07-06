<?php

namespace App\Services;

use App\Models\Industry;
use App\Contracts\AbstractInterface;
use App\Contracts\IndustryInterface;


/**
 * Class IndustryRepository
 * @package App\Services
 */
class IndustryRepository extends AbstractInterface implements IndustryInterface
{
    /**
     * IndustryRepository constructor.
     * @param Industry $model
     */
    public function __construct(Industry $model)
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
            'name' => $attributes['name']
        ];
    }
}