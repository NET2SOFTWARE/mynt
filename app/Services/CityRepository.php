<?php

namespace App\Services;

use App\Models\City;
use App\Contracts\CityInterface;
use App\Contracts\AbstractInterface;


/**
 * Class CityRepository
 * @package App\Services
 */
class CityRepository extends AbstractInterface implements CityInterface
{
    /**
     * CityRepository constructor.
     * @param City $model
     */
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'name'      => $attributes['name'],
            'state_id'  => $attributes['state_id'],
        ];
    }

    /**
     * @param int $stateId
     * @param array $columns
     * @return mixed
     */
    public function sortByStateId(int $stateId, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->get($columns);
    }

    /**
     * @param string $stateName
     * @param array $columns
     * @return mixed
     */
    public function sortByStateName(string $stateName, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->get($columns);
    }

    /**
     * @param int $countryId
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryId(int $countryId, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryId) {
            $query->where('id', '=', $countryId);
        })->get($columns);
    }

    /**
     * @param string $countryName
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryName(string $countryName, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryName) {
            $query->where('name', '=', $countryName);
        })->get($columns);
    }

    /**
     * @param int $stateId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdWith(int $stateId, array $relations, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->with($relations)->get($columns);
    }

    /**
     * @param string $stateName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNameWith(string $stateName, array $relations, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->with($relations)->get($columns);
    }

    /**
     * @param int $countryId
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdWith(int $countryId, array $relations, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryId) {
            $query->where('id', '=', $countryId);
        })->with($relations)->get($columns);
    }

    /**
     * @param string $countryName
     * @param array $relations
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNameWith(string $countryName, array $relations, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryName) {
            $query->where('name', '=', $countryName);
        })->with($relations)->get($columns);
    }

    /**
     * @param int $stateId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdPaginate(int $stateId, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->paginate($limit, $columns);
    }

    /**
     * @param string $stateName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNamePaginate(string $stateName, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->paginate($limit, $columns);
    }

    /**
     * @param int $countryId
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginate(int $countryId, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryId) {
            $query->where('id', '=', $countryId);
        })->paginate($limit, $columns);
    }

    /**
     * @param string $countryName
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginate(string $countryName, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryName) {
            $query->where('name', '=', $countryName);
        })->paginate($limit, $columns);
    }

    /**
     * @param int $stateId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateIdPaginateWith(int $stateId, array $relations, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->with($relations)->paginate($limit, $columns);
    }

    /**
     * @param string $stateName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByStateNamePaginateWith(string $stateName, array $relations, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('states', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->with($relations)->paginate($limit, $columns);
    }

    /**
     * @param int $countryId
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryIdPaginateWith(int $countryId, array $relations, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryId) {
            $query->where('id', '=', $countryId);
        })->with($relations)->paginate($limit, $columns);
    }

    /**
     * @param string $countryName
     * @param array $relations
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByCountryNamePaginateWith(string $countryName, array $relations, int $limit = 20, array $columns = ['*'])
    {
        return $this->model->whereHas('countries', function ($query) use ($countryName) {
            $query->where('name', '=', $countryName);
        })->with($relations)->paginate($limit, $columns);
    }
}