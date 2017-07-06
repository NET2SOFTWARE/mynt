<?php

namespace App\Services;

use App\User;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;

class UserService
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $db;

    /**
     * @var string
     */
    private $table;

    /**
     * UserService constructor.
     * @param \Illuminate\Database\Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
        $this->table = 'users';
    }

    public function gets($paginate = null)
    {
        return (is_null($paginate))
            ? User::whereHas('roles', function ($query) {$query->where('role_id', '=', 3);})->all()
            : User::whereHas('roles', function ($query) {$query->where('role_id', '=', 3);})->paginate($paginate);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getUserById($value)
    {
        $user = $this->db
                    ->table($this->table)
                    ->where('id', '=', $value)
                    ->first();

        return $user;
    }
}