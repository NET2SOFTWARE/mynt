<?php

namespace App\Contracts;


/**
 * Interface ContactInterface
 * @package App\Contracts
 */
interface ContactInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}