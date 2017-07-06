<?php

namespace App\Contracts;

interface ParentAccountInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getParent(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
}