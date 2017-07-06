<?php

namespace App\Services;

use App\Models\Contact;
use App\Contracts\AbstractInterface;
use App\Contracts\ContactInterface;


class ContactRepository extends AbstractInterface implements ContactInterface
{

    public function __construct(Contact $model)
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
            'device'    => str_is('021*', $attributes['phone']) ? 'phone' : 'mobile',
            'number'    => $attributes['phone'],
        ];
    }
}