<?php

namespace App\Contracts;


/**
 * Interface RoleInterface
 * @package App\Contracts
 */
interface RoleInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function gets(array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @param string $name
     * @param array $columns
     * @return mixed
     */
    public function sortByName(string $name, array $columns = ['*']);

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $limit = 25, array $columns = ['*']);

    /**
     * @param string $name
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function sortByNamePaginate(string $name, int $limit = 25, array $columns = ['*']);

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