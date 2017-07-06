<?php

namespace App\Contracts;

interface GlobalPassbookInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @return mixed
     */
    public function gets();

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 20);

    /**
     * @return mixed
     */
    public function lastBalance();

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param int $globalPassbookId
     * @param int $transactionId
     * @return mixed
     */
    public function attachTransaction(int $globalPassbookId, int $transactionId);
}