<?php

namespace App\Contracts;

interface RemittanceInquiryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @return mixed
     */
    public function getLastKey();

    /**
     * @param string $index
     * @param string $value
     * @return mixed
     */
    public function getBy(string $index, string $value);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}