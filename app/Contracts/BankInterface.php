<?php

namespace App\Contracts;


/**
 * Interface BankInterface
 * @package App\Contracts
 */
interface BankInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    public function getByCode(string $bankCode);
}