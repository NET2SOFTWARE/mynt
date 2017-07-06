<?php

namespace App\Services;

use App\Models\Identity;
use App\Contracts\AbstractInterface;
use App\Contracts\IdentityInterface;

/**
 * Class IdentityRepository
 * @package App\Services
 */
class IdentityRepository extends AbstractInterface implements IdentityInterface
{
    /**
     * IdentityRepository constructor.
     * @param Identity $model
     */
    public function __construct(Identity $model)
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