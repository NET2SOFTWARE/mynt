<?php

namespace App\Services;

use App\Admin;
use App\Contracts\AbstractInterface;
use App\Contracts\AdministratorInterface;

/**
 * Class AdministratorRepository
 * @package App\Services
 */
class AdministratorRepository extends AbstractInterface implements AdministratorInterface
{

    /**
     * AdministratorRepository constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
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
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password'])
        ];
    }
}