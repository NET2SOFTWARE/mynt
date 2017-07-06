<?php

namespace App\Services;


use App\Contracts\PicInterface;
use App\Models\Pic;
use Carbon\Carbon;

/**
 * Class PicRepository
 * @package App\Services
 */
class PicRepository implements PicInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return Pic::find($id);
    }

    /**
     * @param array $column
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function gets(array $column = ['*'])
    {
        return Pic::all($column);
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function save(array $data)
    {
        $pic = new Pic;

        foreach ($data as $index => $value) { $pic->$index = $value; }

        $pic->created_at = Carbon::now();
        $pic->updated_at = Carbon::now();

        $pic->save();

        return (!$pic) ? false : $this->get($pic->id);
    }
}