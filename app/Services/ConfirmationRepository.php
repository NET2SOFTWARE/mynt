<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class ConfirmationRepository
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;


    /**
     * ConfirmationRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
        $this->table = 'confirmations';
    }

    /**
     * @return string
     */
    protected function getToken()
    {
        return hash_hmac(
            'sha256',
            str_random(40),
            config('app.key')
        );
    }

    /**
     * @param $user
     * @return string
     */
    public function createConfirmation($user)
    {
        $confirmation = $this->getConfirmation($user);

        if (!$confirmation) {
            return $this->createToken($user);
        }

        return $this->regenerateToken($user);
    }

    /**
     * @param $user
     * @return string
     */
    private function regenerateToken($user)
    {
        $token = $this->getToken();

        $this
            ->db
            ->table($this->table)
            ->where('user_id', $user->id)
            ->update([
                'token'         => $token,
                'created_at'    => Carbon::now()
            ]);

        return $token;
    }

    /**
     * @param $user
     * @return string
     */
    private function createToken($user)
    {
        $token = $this->getToken();

        $this
            ->db
            ->table($this->table)
            ->insert([
                'user_id'       => $user->id,
                'token'         => $token,
                'created_at'    => Carbon::now()
            ]);

        return $token;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getConfirmation($user)
    {
        return $this
            ->db
            ->table($this->table)
            ->where('user_id', $user->id)
            ->first();
    }


    /**
     * @param $token
     * @return mixed
     */
    public function getConfirmationByToken($token)
    {
        return $this
            ->db
            ->table($this->table)
            ->where('token', $token)
            ->first();
    }

    /**
     * @param $token
     * @return int
     */
    public function deleteConfirmation($token)
    {
        return $this
            ->db
            ->table($this->table)
            ->where('token', $token)
            ->delete();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function userMustConfirmed($user)
    {
        $confirmation = $this->db
                            ->table($this->table)
                            ->where('user_id', '=', $user->id)
                            ->first();

        return (!$confirmation)
            ? false
            : true;
    }
}