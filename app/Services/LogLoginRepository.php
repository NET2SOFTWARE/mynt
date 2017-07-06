<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\LogLogin;
use App\Contracts\LogLoginInterface;

class LogLoginRepository implements LogLoginInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return LogLogin::find($id);
    }

    /**
     * @return mixed
     */
    public function gets()
    {
        return LogLogin::orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 15)
    {
        return LogLogin::orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * @param string $index
     * @param string $value
     * @return mixed
     */
    public function sort(string $index, string $value)
    {
        return LogLogin::where($index, $value)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function save(array $data)
    {
        $log = new LogLogin;

        foreach ($data as $index => $value) {$log->$index = $value;}

        $log->created_at = Carbon::now();
        $log->updated_at = Carbon::now();

        return (!$log) ? false : $this->get($log->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|mixed
     */
    public function update(int $id, array $data)
    {
        $log = LogLogin::find($id);

        foreach ($data as $index => $value) {$log->$index = $value;}

        $log->updated_at = Carbon::now();

        return (!$log) ? false : $this->get($log->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return LogLogin::find($id)->delete();
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getsByUserId(int $userId)
    {
        $log = LogLogin::where(function ($query) use ($userId) {
                $query->whereHas('users', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $log;
    }

    /**
     * @param int $userId
     * @param int $limit
     * @return mixed
     */
    public function paginateByUserId(int $userId, int $limit = 15)
    {
        $log = LogLogin::where(function ($query) use ($userId) {
            $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return $log;
    }
}