<?php

namespace App\Contracts;


interface NotificationInterface
{
    public function get(int $id);

    public function gets();

    public function paginate(int $limit = 15);

    public function sort(string $index, string $value);

    public function save(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getsByUserId(int $userId);

    public function paginateByUserId(int $userId, int $limit = 15);
}