<?php

namespace App\Contracts;


/**
 * Interface PartnershipInterface
 * @package App\Contracts
 */
interface PartnershipInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}