<?php

namespace App\Contracts;


/**
 * Interface IndustryInterface
 * @package App\Contracts
 */
interface IndustryInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}