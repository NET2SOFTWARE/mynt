<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Limit;
use App\Contracts\LimitInterface;

class LimitRepository implements LimitInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return Limit::find((int) $id);
    }

    /**
     * @return mixed
     */
    public function gets()
    {
        return Limit::all();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 15)
    {
        return Limit::paginate($limit);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $limit = new Limit;

        foreach ($data as $index => $value) { $limit->$index = $value; }

        $limit->create_at   = Carbon::now()->format('Y-m-d H:i:s');
        $limit->updated_at  = Carbon::now()->format('Y-m-d H:i:s');
        $limit->save();

        return (!$limit) ? (bool) false : collect(Limit::find((int) $limit->id));
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $limit = Limit::find((int) $id);

        foreach ($data as $index => $value) { $limit->$index = $value; }

        $limit->updated_at = Carbon::now()->format('Y-m-d H:i:s');

        return (!$limit) ? (bool) false : collect(Limit::find((int) $limit->id));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $limit = Limit::find((int) $id);

        return $limit->delete();
    }
}