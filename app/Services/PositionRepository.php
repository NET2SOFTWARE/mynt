<?php

namespace App\Services;


use App\Contracts\PositionInterface;
use App\Models\Position;
use Carbon\Carbon;

/**
 * Class PositionRepository
 * @package App\Services
 */
class PositionRepository implements PositionInterface
{

    /**
     * @param int $id
     * @param array $columns
     * @return bool
     */
    public function get(int $id, array $columns = ['*'])
    {
        $position = Position::find($id);

        return (!$position) ? false : $position;
    }

    /**
     * @param array $columns
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function gets(array $columns = ['*'])
    {
        $position = Position::all($columns);

        return (!$position) ? false : $position;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        $position = new Position;

        foreach ($data as $index => $value) { $position->$index = $value; }

        $position->created_at = Carbon::now();
        $position->updated_at = Carbon::now();

        $position->save();

        return (!$position) ? false : $this->get($position->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $position = Position::find($id);

        $position->update($data);

        return (!$position) ? false : $this->get($position->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $position = Position::find($id);

        return $position->delete();
    }
}