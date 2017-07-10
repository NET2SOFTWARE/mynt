<?php

namespace App\Services;


use App\Contracts\AreaInterface;
use App\Models\Area;

class AreaRepository implements AreaInterface
{

    public function gets()
    {
        return Area::all();
    }

    public function get(int $id)
    {
        return Area::find((int) $id);
    }
}