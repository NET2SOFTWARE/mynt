<?php

namespace App\Contracts;


/**
 * Interface AdministratorInterface
 * @package App\Contracts
 */
interface AdministratorInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}