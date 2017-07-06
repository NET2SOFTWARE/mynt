<?php

namespace App\Contracts;


/**
 * Interface IdentityInterface
 * @package App\Contracts
 */
interface IdentityInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}