<?php

namespace App\Contracts;


/**
 * Interface TransactionInterface
 * @package App\Contracts
 */

interface TransactionInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function transactionSuccess(int $limit = 20, array $columns = ['*']);

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function transactionFailed(int $limit = 20, array $columns = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function inquiry(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}