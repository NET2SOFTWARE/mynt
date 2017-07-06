<?php

namespace App\Contracts;


interface PassbookInterface
{
    public function attribute(array $attributes);
    public function get(int $idPassbook);
    public function save(array $data);
    public function insert(array $data);
    public function attachAccounts(int $idPassbook, int $idAccount);

    public function getPassbooksByAccountNumber(string $accountNumber, int $limit = 20);
}