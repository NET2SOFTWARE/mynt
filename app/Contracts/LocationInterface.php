<?php

namespace App\Contracts;


/**
 * Interface LocationInterface
 * @package App\Contracts
 */
interface LocationInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}