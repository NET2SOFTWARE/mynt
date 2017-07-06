<?php

namespace App\Contracts;


/**
 * Interface StateInterface
 * @package App\Contracts
 */
interface StateInterface extends AppInterface
{

    /**
     * @param $attributes
     * @return mixed
     */
    public function attribute($attributes);
    /**
     * @param $cityId
     * @param array $columns
     * @return mixed
     */
    public function getByCityId($cityId, array $columns = ['*']);

    /**
     * @param $cityName
     * @param array $columns
     * @return mixed
     */
    public function getByCityName($cityName, array $columns = ['*']);

    /**
     * @param $cityId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function getByCityIdWith($cityId, array $relations, array $columns = ['*']);

    /**
     * @param $cityName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function getByCityNameWith($cityName, array $relations, array $columns = ['*']);

    /**
     * @param $countryId
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryId($countryId, array $columns = ['*']);

    /**
     * @param $countryName
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryName($countryName, array $columns = ['*']);

    /**
     * @param $countryId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdWith($countryId, array $relations, array $columns = ['*']);

    /**
     * @param $countryName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNameWith($countryName, array $relations, array $columns = ['*']);

    /**
     * @param $countryId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginate($countryId, int $limit, array $columns = ['*']);

    /**
     * @param $countryName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginate($countryName, int $limit, array $columns = ['*']);

    /**
     * @param $countryId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginateWith($countryId, array $relations, int $limit, array $columns = ['*']);

    /**
     * @param $countryName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginateWith($countryName, array $relations, int $limit, array $columns = ['*']);
}