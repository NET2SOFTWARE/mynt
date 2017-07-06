<?php

namespace App\Services;

use App\Models\State;
use App\Contracts\StateInterface;
use App\Contracts\AbstractInterface;

/**
 * Class StateRepository
 * @package App\Services
 */
class StateRepository extends AbstractInterface implements StateInterface
{

    /**
     * @param $attributes
     * @return array
     */
    public function attribute($attributes)
    {
        return [
            'name'          => $attributes['name'],
            'country_id'    => $attributes['country_id']
        ];
    }
    /**
     * StateRepository constructor.
     * @param State $model
     */
    public function __construct(State $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $cityId
     * @param array $columns
     * @return mixed
     */
    public function getByCityId($cityId, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('city', function ($query) use ($cityId) {
                $query->where('id', '=', $cityId);
            })->first($columns);
    }

    /**
     * @param $cityName
     * @param array $columns
     * @return mixed
     */
    public function getByCityName($cityName, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('city', function ($query) use ($cityName) {
                $query->where('name', '=', $cityName);
            })->first($columns);
    }

    /**
     * @param $cityId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function getByCityIdWith($cityId, array $relations, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('city', function ($query) use ($cityId) {
                $query->where('id', '=', $cityId);
            })->with($relations)->first($columns);
    }

    /**
     * @param $cityName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function getByCityNameWith($cityName, array $relations, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('city', function ($query) use ($cityName) {
                $query->where('name', '=', $cityName);
            })->with($relations)->first($columns);
    }

    /**
     * @param $countryId
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryId($countryId, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryId) {
                $query->where('id', '=', $countryId);
            })->get($columns);
    }

    /**
     * @param $countryName
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryName($countryName, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryName) {
                $query->where('name', '=', $countryName);
            })->get($columns);
    }

    /**
     * @param $countryId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdWith($countryId, array $relations, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryId) {
                $query->where('id', '=', $countryId);
            })->with($relations)->get($columns);
    }

    /**
     * @param $countryName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNameWith($countryName, array $relations, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryName) {
                $query->where('name', '=', $countryName);
            })->with($relations)->get($columns);
    }

    /**
     * @param $countryId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginate($countryId, int $limit, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryId) {
                $query->where('id', '=', $countryId);
            })->paginate($limit, $columns);
    }

    /**
     * @param $countryName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginate($countryName, int $limit, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryName) {
                $query->where('name', '=', $countryName);
            })->paginate($limit, $columns);
    }

    /**
     * @param $countryId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginateWith($countryId, array $relations, int $limit, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryId) {
                $query->where('id', '=', $countryId);
            })->with($relations)->paginate($limit, $columns);
    }

    /**
     * @param $countryName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginateWith($countryName, array $relations, int $limit, array $columns = ['*'])
    {
        return $this->model
            ->whereHas('countries', function ($query) use ($countryName) {
                $query->where('name', '=', $countryName);
            })->with($relations)->paginate($limit, $columns);
    }
}