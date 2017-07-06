<?php

namespace App\Contracts;

/**
 * Interface CityInterface
 * @package App\Contracts
 */
interface CityInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param int $stateId
     * @param array $columns
     * @return mixed
     */
    public function sortByStateId(int $stateId, array $columns = ['*']);

    /**
     * @param string $stateName
     * @param array $columns
     * @return mixed
     */
    public function sortByStateName(string $stateName, array $columns = ['*']);

    /**
     * @param int $countryId
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryId(int $countryId, array $columns = ['*']);

    /**
     * @param string $countryName
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryName(string $countryName, array $columns = ['*']);

    /**
     * @param int $stateId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdWith(int $stateId, array $relations, array $columns = ['*']);

    /**
     * @param string $stateName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNameWith(string $stateName, array $relations, array $columns = ['*']);

    /**
     * @param int $countryId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdWith(int $countryId, array $relations, array $columns = ['*']);

    /**
     * @param string $countryName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNameWith(string $countryName, array $relations, array $columns = ['*']);

    /**
     * @param int $stateId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdPaginate(int $stateId, int $limit = 20, array $columns = ['*']);

    /**
     * @param string $stateName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNamePaginate(string $stateName, int $limit = 20, array $columns = ['*']);

    /**
     * @param int $countryId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginate(int $countryId, int $limit = 20, array $columns = ['*']);

    /**
     * @param string $countryName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginate(string $countryName, int $limit = 20, array $columns = ['*']);

    /**
     * @param int $stateId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdPaginateWith(int $stateId, array $relations, int $limit = 20, array $columns = ['*']);

    /**
     * @param string $stateName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNamePaginateWith(string $stateName, array $relations, int $limit = 20, array $columns = ['*']);

    /**
     * @param int $countryId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginateWith(int $countryId, array $relations, int $limit = 20, array $columns = ['*']);

    /**
     * @param string $countryName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginateWith(string $countryName, array $relations, int $limit = 20, array $columns = ['*']);
}