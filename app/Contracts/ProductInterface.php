<?php

namespace App\Contracts;


/**
 * Interface ProductInterface
 * @package App\Contracts
 */
interface ProductInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}