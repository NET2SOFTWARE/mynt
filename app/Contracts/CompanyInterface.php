<?php

namespace App\Contracts;

/**
 * Interface CompanyInterface
 * @package App\Contracts
 */
/**
 * Interface CompanyInterface
 * @package App\Contracts
 */
interface CompanyInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param string $partnership
     * @return mixed
     */
    public function sortCompanyByPartnership(string $partnership);

    /**
     * @param string $companyCode
     * @return mixed
     */
    public function getByCode(string $companyCode);

    /**
     * @param string $companyCode
     * @return mixed
     */
    public function getIdByCode(string $companyCode);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param string $code
     * @return mixed
     */
    public function getCompanyByCode(string $code);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getCompanyByUserId(int $userId);

    /**
     * @param string $accountNumber
     * @return mixed
     */
    public function getCompanyByAccountNumber(string $accountNumber);
}