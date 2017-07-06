<?php

namespace App\Services;

use App\Models\Country;
use App\Contracts\CountryInterface;
use App\Contracts\AbstractInterface;

class CountryRepository extends AbstractInterface implements CountryInterface
{
    /**
     * CountryRepository constructor.
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attribute
     * @return array
     */
    public function attribute(array $attribute)
    {
        return [
            'name'      => $attribute['name'],
            'iso'       => $attribute['iso'],
            'currency'  => $attribute['currency'],
        ];
    }

    /**
     * @param string $stateId
     * @return mixed
     */
    public function getByStateId(string $stateId)
    {
        return $this->model->whereHas('state', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->first();
    }

    /**
     * @param string $stateName
     * @return mixed
     */
    public function getByStateName(string $stateName)
    {
        return $this->model->whereHas('state', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->first();
    }

    /**
     * @param string $stateId
     * @return mixed
     */
    public function sortByStateId(string $stateId)
    {
        return $this->model->whereHas('state', function ($query) use ($stateId) {
            $query->where('id', '=', $stateId);
        })->get();
    }

    /**
     * @param string $stateName
     * @return mixed
     */
    public function sortByStateName(string $stateName)
    {
        return $this->model->whereHas('state', function ($query) use ($stateName) {
            $query->where('name', '=', $stateName);
        })->get();
    }

    /**
     * @param string $cityId
     * @return mixed
     */
    public function getByCityId(string $cityId)
    {
        return $this->model->has('state', function ($query) use ($cityId) {
            $query->whereHas('city', function ($query) use ($cityId) {
                $query->where('id', '=', $cityId);
            });
        })->first();
    }

    /**
     * @param string $cityName
     * @return mixed
     */
    public function getByCityName(string $cityName)
    {
        return $this->model->has('state', function ($query) use ($cityName) {
            $query->whereHas('city', function ($query) use ($cityName) {
                $query->where('name', '=', $cityName);
            });
        })->first();
    }

    /**
     * @param string $cityId
     * @return mixed
     */
    public function sortByCityId(string $cityId)
    {
        return $this->model->has('state', function ($query) use ($cityId) {
            $query->whereHas('city', function ($query) use ($cityId) {
                $query->where('id', '=', $cityId);
            });
        })->get();
    }

    /**
     * @param string $cityName
     * @return mixed
     */
    public function sortByCityName(string $cityName)
    {
        return $this->model->has('state', function ($query) use ($cityName) {
            $query->whereHas('city', function ($query) use ($cityName) {
                $query->where('name', '=', $cityName);
            });
        })->get();
    }
}