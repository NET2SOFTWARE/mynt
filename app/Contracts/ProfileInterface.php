<?php

namespace App\Contracts;


/**
 * Interface ProfileInterface
 * @package App\Contracts
 */
interface ProfileInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}