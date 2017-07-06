<?php

namespace App\Contracts;


/**
 * Interface AccountInterface
 * @package App\Contracts
 */

interface AccountInterface extends AppInterface
{
    /**
     * @param $accountNumber
     * @return mixed
     * @internal param int $accountId
     */
    public function isAccountRegistered($accountNumber);

    /**
     * @param $accountNumber
     * @return mixed
     */
    public function getLastBalance($accountNumber);

    /**
     * @param $accountNumber
     * @return mixed
     * @internal param int $accountId
     */
    public function getBalanceLimit($accountNumber);

    /**
     * @param $accountNumber
     * @return mixed
     * @internal param int $accountId
     */
    public function getTransactionLimit($accountNumber);

    /**
     * @param $accountNumber
     * @param $nominal
     * @return mixed
     */
    public function isBalanceEnough($accountNumber, $nominal);

    /**
     * @param $accountNumber
     * @return mixed
     */
    public function isBalanceNull($accountNumber);

    /**
     * @param $accountNumber
     * @param $nominal
     * @return mixed
     */
    public function isBalanceOverLimit($accountNumber, $nominal);

    /**
     * @param $accountNumber
     * @param $nominal
     * @return mixed
     */
    public function isTransactionOverLimit($accountNumber, $nominal);

    /**
     * @param string $accountNumber
     * @return mixed
     */
    public function getCalculateTransactionMonthly($accountNumber);

    /**
     * @param $accountNumber
     * @return mixed
     */
    public function isNullPin($accountNumber);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param $accountNumber
     * @return mixed
     */
    public function checkExistingAccount($accountNumber);

    /**
     * @param string $number
     * @return mixed
     */
    public function getAccountByNumber(string $number);

    /**
     * @param string $myntId
     * @return mixed
     */
    public function getAccountByMyntId(string $myntId);
}