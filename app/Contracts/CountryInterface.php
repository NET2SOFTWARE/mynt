<?php

namespace App\Contracts;

/**
 * Interface CountryInterface
 * @package App\Contracts
 */
interface CountryInterface extends AppInterface
{
    /**
     * @param array $attribute
     * @return mixed
     */
    public function attribute(array $attribute);

    /**
     * @param string $stateId
     * @return mixed
     */
    public function getByStateId(string $stateId);

    /**
     * @param string $stateName
     * @return mixed
     */
    public function getByStateName(string $stateName);

    /**
     * @param string $cityId
     * @return mixed
     */
    public function getByCityId(string $cityId);

    /**
     * @param string $cityName
     * @return mixed
     */
    public function getByCityName(string $cityName);

    /**
     * @param string $stateId
     * @return mixed
     */
    public function sortByStateId(string $stateId);

    /**
     * @param string $stateName
     * @return mixed
     */
    public function sortByStateName(string $stateName);

    /**
     * @param string $cityId
     * @return mixed
     */
    public function sortByCityId(string $cityId);

    /**
     * @param string $cityName
     * @return mixed
     */
    public function sortByCityName(string $cityName);
}