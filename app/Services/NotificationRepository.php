<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Notification;
use App\Contracts\NotificationInterface;

class NotificationRepository implements NotificationInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return Notification::find($id);
    }

    /**
     * @return mixed
     */
    public function gets()
    {
        return Notification::orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 15)
    {
        return Notification::orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * @param string $index
     * @param string $value
     * @return mixed
     */
    public function sort(string $index, string $value)
    {
        return Notification::where($index, $value)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function save(array $data)
    {
        $notification = new Notification;

        foreach ($data as $index => $value) {$notification->$index = $value;}

        $notification->created_at = Carbon::now();
        $notification->updated_at = Carbon::now();

        return (!$notification) ? false : $this->get($notification->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|mixed
     */
    public function update(int $id, array $data)
    {
        $notification = Notification::find($id);

        foreach ($data as $index => $value) {$notification->$index = $value;}

        $notification->updated_at = Carbon::now();

        return (!$notification) ? false : $this->get($notification->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return Notification::find($id)->delete();
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getsByUserId(int $userId)
    {
        $notification = Notification::where(function ($query) use ($userId) {
            $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return $notification;
    }

    /**
     * @param int $userId
     * @param int $limit
     * @return mixed
     */
    public function paginateByUserId(int $userId, int $limit = 15)
    {
        $notification = Notification::where(function ($query) use ($userId) {
            $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return $notification;
    }
}