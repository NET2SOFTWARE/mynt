<?php

namespace App\Services;

use App\Contracts\AbstractInterface;
use App\Contracts\ProfileInterface;
use App\Models\Profile;

class ProfileRepository extends AbstractInterface implements ProfileInterface
{

    public function __construct(Profile $model)
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
            'gender'                    => $attributes['gender'],
            'born_place'                => $attributes['born_place'],
            'born_date'                 => date('Y-m-d', strtotime($attributes['born_date'])),
            'identity_id'               => $attributes['identity_id'],
            'identity_number'           => $attributes['identity_number'],
            'identity_expired_date'     => date('Y-m-d', strtotime($attributes['identity_expired_date'])),
            'mother_name'               => $attributes['mother_name'],
            'document'                  => $attributes['document'],
            'status'                    => $attributes['status'],
        ];
    }
}