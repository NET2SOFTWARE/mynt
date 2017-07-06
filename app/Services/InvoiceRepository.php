<?php

namespace App\Services;

use App\Contracts\InvoiceInterface;
use App\Contracts\AbstractInterface;


/**
 * Class InvoiceRepository
 * @package App\Services
 */
class InvoiceRepository extends AbstractInterface implements InvoiceInterface
{

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'trx_id'    => $attributes['trx_id'],
            'user_id'   => $attributes['user_id'],
        ];
    }

    /**
     * @param string $emailTo
     * @param array $data
     * @return mixed
     */
    public function send(string $emailTo, array $data)
    {
        // TODO: Implement send() method.
    }
}