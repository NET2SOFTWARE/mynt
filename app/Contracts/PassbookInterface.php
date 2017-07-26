<?php

namespace App\Contracts;


interface PassbookInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param int $idPassbook
     * @return mixed
     */
    public function get(int $idPassbook);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

    /**
     * @param int $idPassbook
     * @param int $idAccount
     * @return mixed
     */
    public function attachAccounts(int $idPassbook, int $idAccount);

    /**
     * @param string $accountNumber
     * @param int $limit
     * @return mixed
     */
    public function getPassbooksByAccountNumber(string $accountNumber, int $limit = 20);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}