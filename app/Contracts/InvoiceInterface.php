<?php

namespace App\Contracts;


/**
 * Interface InvoiceInterface
 * @package App\Contracts
 */
interface InvoiceInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param string $emailTo
     * @param array $data
     * @return mixed
     */
    public function send(string $emailTo, array $data);
}