<?php

namespace App\Contracts;


interface PositionInterface
{
    public function get(int $id, array $columns = ['*']);
    public function gets(array $columns = ['*']);
    public function save(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}