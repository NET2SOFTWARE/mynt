<?php

namespace App\Contracts;

interface AccessConfigurationInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function gets(array $columns = ['*']);

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function getById(int $id, array $columns = ['*']);

    /**
     * @param string $name
     * @param array $columns
     * @return mixed
     */
    public function getByName(string $name, array $columns = ['*']);

    /**
     * @param string $name
     * @param array $columns
     * @return mixed
     */
    public function getsByName(string $name, array $columns = ['*']);

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