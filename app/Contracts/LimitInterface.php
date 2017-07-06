<?php

namespace App\Contracts;


interface LimitInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @return mixed
     */
    public function gets();

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 15);

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}