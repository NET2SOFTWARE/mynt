<?php

namespace App\Contracts;


/**
 * Interface AppInterface
 * @package App\Contracts
 */
/**
 * Interface AppInterface
 * @package App\Contracts
 */
/**
 * Interface AppInterface
 * @package App\Contracts
 */
/**
 * Interface AppInterface
 * @package App\Contracts
 */
/**
 * Interface AppInterface
 * @package App\Contracts
 */
interface AppInterface
{
    /**
     * @param array $column
     * @return mixed
     */
    public function gets(array $column = ['*']);

    /**
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function getsWith(string $relations, array $column = ['*']);

    /**
     * @param int $limit
     * @param array $column
     * @return mixed
     */
    public function getsPaginate(int $limit = 20, array $column = ['*']);


    /**
     * @param string $relations
     * @param int $limit
     * @param array $column
     * @return mixed
     */
    public function getsPaginateWith(string $relations, int $limit = 20, array $column = ['*']);

    /**
     * @param int $id
     * @param array $column
     * @return mixed
     */
    public function get(int $id, array $column = ['*']);

    /**
     * @param string $index
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function getBy(string $index = 'id', $value, array $column = ['*']);

    /**
     * @param string $index
     * @param $value
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function getByWith(string $index = 'id', $value, string $relations, array $column = ['*']);

    /**
     * @param int $id
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function getWith(int $id, string $relations, array $column = ['*']);

    /**
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sort(string $index, string $operator = '=', $value, array $column = ['*']);

    /**
     * @param string $index
     * @param string $operator
     * @param $value
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function sortWith(string $index, string $operator = '=', $value, string $relations, array $column = ['*']);

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit);

    /**
     * @param int $limit
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortPaginate(int $limit, string $index, string $operator = '=', $value, array $column = ['*']);

    /**
     * @param int $limit
     * @param string $relation
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortPaginateWith(int $limit, string $relation, string $index, string $operator = '=', $value, array $column = ['*']);

    /**
     * @param string $relationsTable
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortByRelation(string $relationsTable, string $index, $value, string $operator = '=', array $column = ['*']);

    /**
     * @param string $relationsTable
     * @param string $index
     * @param $value
     * @param int $limit
     * @param string $operator
     * @param array $column
     * @return mixed
     */
    public function sortByRelationPaginate(string $relationsTable, string $index, $value, int $limit = 20, string $operator = '=', array $column = ['*']);

    /**
     * @param string $relationsTable
     * @param string $index
     * @param $value
     * @param string $relations
     * @param string $operator
     * @param array $column
     * @return mixed
     */
    public function sortByRelationWith(string $relationsTable, string $index, $value, string $relations, string $operator = '=', array $column = ['*']);

    /**
     * @param string $relationsTable
     * @param string $index
     * @param $value
     * @param string $relations
     * @param int $limit
     * @param string $operator
     * @param array $column
     * @return mixed
     */
    public function sortByRelationPaginateWith(string $relationsTable, string $index, $value, string $relations, int $limit = 20, string $operator = '=', array $column = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);


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