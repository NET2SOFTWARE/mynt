<?php

namespace App\Contracts;


/**
 * Interface InquiryInterface
 * @package App\Contracts
 */
interface InquiryInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
    public function save(array $data);
}