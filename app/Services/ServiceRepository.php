<?php

namespace App\Services;

use App\Models\Service;
use App\Contracts\ServiceInterface;
use App\Contracts\AbstractInterface;

/**
 * Class ServiceRepository
 * @package App\Services
 */
class ServiceRepository extends AbstractInterface implements ServiceInterface
{

    /**
     * ServiceRepository constructor.
     * @param Service $model
     */
    public function __construct(Service $model)
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
        ];
    }
}