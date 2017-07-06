<?php

namespace App\Contracts;


interface PicInterface
{
    public function get(int $id);
    public function gets(array $column = ['*']);
    public function save(array $data);
}