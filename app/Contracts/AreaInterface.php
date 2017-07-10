<?php

namespace App\Contracts;


interface AreaInterface
{
    public function gets();
    public function get(int $id);
}