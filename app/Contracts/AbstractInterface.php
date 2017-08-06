<?php

namespace App\Contracts;

/**
 * Class AbstractInterface
 * @package App\Contracts
 */
/**
 * Class AbstractInterface
 * @package App\Contracts
 */
abstract class AbstractInterface
{

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param $model
     * AbstractInterface constructor.
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param array $column
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function gets(array $column = ['*'])
    {
        return $this->model
                    ->all($column);
    }

    /**
     * @param string $relations
     * @param array $column
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getsWith(string $relations, array $column = ['*'])
    {
        $as = explode(',', $relations);

        foreach ($as as $data) {
            $this->model->with($data);
        }

        return $this->model->get($column);
    }

    /**
     * @param int $limit
     * @param array $column
     * @return mixed
     */
    public function getsPaginate(int $limit = 20, array $column = ['*'])
    {
        return $this->model
                    ->orderBy('id', 'asc')
                    ->paginate($limit, $column);
    }

    /**
     * @param string $relations
     * @param int $limit
     * @param array $column
     * @return mixed
     */
    public function getsPaginateWith(string $relations, int $limit = 20, array $column = ['*'])
    {
        $_model = $this->model;

        $parts = explode(',', $relations);

        foreach ($parts as $part) $_model->with($part);

        return $_model->paginate($limit, $column);
    }

    /**
     * @param int $id
     * @param array $column
     * @return mixed
     */
    public function get(int $id, array $column = ['*'])
    {
        return $this->model
            ->where('id', '=', $id)
            ->first($column);
    }

    /**
     * @param string $index
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function getBy(string $index = 'id', $value, array $column = ['*'])
    {
        return $this->model->where($index, '=', $value)->first($column);
    }

    /**
     * @param string $index
     * @param $value
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function getByWith(string $index = 'id', $value, string $relations, array $column = ['*'])
    {
        $_model = $this->model->where($index, '=', $value);

        $_parts = explode(',', $relations);

        foreach($_parts as $_part) $_model->with($_part);
        
        return $_model->first($column);
    }

    /**
     * @param int $id
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function getWith(int $id, string $relations, array $column = ['*'])
    {
        $model = $this->model->where('id', '=', $id);

        $as = explode(',', $relations);

        foreach ($as as $a) {
            $model->with($a);
        }

        return $model->first($column);
    }

    /**
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sort(string $index, string $operator = '=', $value, array $column = ['*'])
    {
        return $this->model
                    ->where($index, $operator, $value)
                    ->get($column);
    }

    /**
     * @param string $index
     * @param string $operator
     * @param $value
     * @param string $relations
     * @param array $column
     * @return mixed
     */
    public function sortWith(string $index, string $operator = '=', $value, string $relations, array $column = ['*'])
    {
        return $this->model
                    ->where($index, $operator, $value)
                    ->with($relations)
                    ->get($column);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit)
    {
        return $this->model
                    ->paginate($limit);
    }

    /**
     * @param int $limit
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortPaginate(int $limit, string $index, string $operator = '=', $value, array $column = ['*'])
    {
        return $this->model
                    ->where($index, $operator, $value)
                    ->paginage($limit, $column);
    }

    /**
     * @param int $limit
     * @param string $relations
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortPaginateWith(int $limit, string $relations, string $index, string $operator = '=', $value, array $column = ['*'])
    {
        return $this->model
                    ->where($index, $operator, $value)
                    ->with($relations)
                    ->paginate($limit, $column);
    }

    /**
     * @param string $relationsTable
     * @param string $index
     * @param string $operator
     * @param $value
     * @param array $column
     * @return mixed
     */
    public function sortByRelation(string $relationsTable, string $index, $value, string $operator = '=', array $column = ['*'])
    {
        return $this->model
                ->whereHas($relationsTable, function ($query) use ($index, $operator, $value) {
                    $query->where($index, $operator, $value);
                })
                ->get($column);
    }

    /**
     * @param string $relationsTable
     * @param string $index
     * @param $value
     * @param int $limit
     * @param string $operator
     * @param array $column
     * @return mixed
     */
    public function sortByRelationPaginate(string $relationsTable, string $index, $value, int $limit = 20, string $operator = '=', array $column = ['*'])
    {
        return $this->model
            ->whereHas($relationsTable, function ($query) use ($index, $operator, $value) {
                $query->where($index, $operator, $value);
            })
            ->paginate($limit, $column);
    }

    /**
     * @param string $relationsTable
     * @param string $index
     * @param $value
     * @param string $relations
     * @param string $operator
     * @param array $column
     * @return mixed
     */
    public function sortByRelationWith(string $relationsTable, string $index, $value, string $relations, string $operator = '=', array $column = ['*'])
    {
        return $this->model
            ->whereHas($relationsTable, function ($query) use ($index, $operator, $value) {
                $query->where($index, $operator, $value);
            })
            ->with($relations)
            ->get($column);
    }

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
    public function sortByRelationPaginateWith(string $relationsTable, string $index, $value, string $relations, int $limit = 20, string $operator = '=', array $column = ['*'])
    {
        return $this->model
            ->whereHas($relationsTable, function ($query) use ($index, $operator, $value) {
                $query->where($index, $operator, $value);
            })
            ->with($relations)
            ->paginate($limit, $column);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data)
    {
        return $this->model
                    ->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->model
                    ->where('id', '=', $id)
                    ->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->model
            ->where('id', '=', $id)
            ->delete();
    }
}