<?php

namespace App\Contracts;


/**
 * Interface MerchantInterface
 * @package App\Contracts
 */
/**
 * Interface MerchantInterface
 * @package App\Contracts
 */
interface MerchantInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @param array $columns
     * @return mixed
     */
    public function gets(array $columns = ['*']);

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 20);

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
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function merchantGroup(int $limit = 20, array $columns = ['*']);

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function merchantIndividual(int $limit = 20, array $columns = ['*']);
}