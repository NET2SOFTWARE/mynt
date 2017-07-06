<?php

namespace App\Services;

use App\Models\AccessConfiguration;
use App\Contracts\AccessConfigurationInterface;
use Carbon\Carbon;

class AccessConfigurationRepository implements AccessConfigurationInterface
{

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function gets(array $columns = ['*'])
    {
        return AccessConfiguration::all();
    }

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function getById(int $id, array $columns = ['*'])
    {
        return AccessConfiguration::find($id);
    }

    /**
     * @param string $name
     * @param array $columns
     * @return mixed
     */
    public function getByName(string $name, array $columns = ['*'])
    {
        return AccessConfiguration::where('name', $name)->first();
    }

    /**
     * @param string $name
     * @param array $columns
     * @return mixed
     */
    public function getsByName(string $name, array $columns = ['*'])
    {
        return AccessConfiguration::where('name', 'LIKE', '%'.$name.'%')->get();
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function save(array $data)
    {
        $accessConfiguration = new AccessConfiguration;

        foreach ($data['data'] as $index => $value) {
            $accessConfiguration->access_name = $value;
        }

        $accessConfiguration->created_at = Carbon::now();
        $accessConfiguration->updated_at = Carbon::now();

        return (!$accessConfiguration) ? false : $this->getById($accessConfiguration->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|mixed
     */
    public function update(int $id, array $data)
    {
        $accessConfiguration = AccessConfiguration::find($id);

        $accessConfiguration->access_name = $data['name'];

        foreach ($data['access'] as $index => $value) {
            $accessConfiguration->access_action->index = $value;
        }

        $accessConfiguration->updated_at = Carbon::now();

        return (!$accessConfiguration) ? false : $this->getById($accessConfiguration->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $accessConfiguration = AccessConfiguration::find($id);

        return $accessConfiguration->delete();
    }
}