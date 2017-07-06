<?php

namespace App\Services;

use App\Models\Location;
use App\Contracts\AbstractInterface;
use App\Contracts\LocationInterface;
use Carbon\Carbon;


class LocationRepository extends AbstractInterface implements LocationInterface
{

    /**
     * LocationRepository constructor.
     * @param Location $model
     */
    public function __construct(Location $model)
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
            'street'    => $attributes['street'],
            'city_id'   => $attributes['city'],
            'zip_code'  => $attributes['zip_code'],
        ];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $location = new Location;

        foreach ($data as $index => $value) { $location->$index = $value; }

        $location->created_at = Carbon::now();
        $location->updated_at = Carbon::now();

        $location->save();

        return (!$location) ? false : Location::find($location->id);
    }
}