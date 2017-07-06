<?php

namespace App\Contracts;


/**
 * Interface ServiceInterface
 * @package App\Contracts
 */
interface ServiceInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}