<?php
/**
 * Created by PhpStorm.
 * User: Net Software
 * Date: 01/07/2017
 * Time: 06.28
 */

namespace App\Contracts;


interface LogLoginInterface
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
     * @param string $index
     * @param string $value
     * @return mixed
     */
    public function sort(string $index, string $value);

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

    /**
     * @param int $userId
     * @return mixed
     */
    public function getsByUserId(int $userId);

    /**
     * @param int $userId
     * @param int $limit
     * @return mixed
     */
    public function paginateByUserId(int $userId, int $limit = 15);
}