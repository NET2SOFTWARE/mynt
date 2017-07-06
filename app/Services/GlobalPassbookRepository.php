<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\GlobalPassbook;
use App\Contracts\GlobalPassbookInterface;

/**
 * Class GlobalPassbookRepository
 * @package App\Services
 */
class GlobalPassbookRepository implements GlobalPassbookInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        $globalPassbook = new GlobalPassbook;
        foreach ($data as $index => $value) {
            $globalPassbook->$index = $value;
        }
        $globalPassbook->created_at = Carbon::now();
        $globalPassbook->updated_at = Carbon::now();
        $globalPassbook->save();

        return (!$globalPassbook) ? false : $this->get($globalPassbook->id);
    }

    /**
     * @param int $globalPassbookId
     * @param int $transactionId
     * @return bool
     */
    public function attachTransaction(int $globalPassbookId, int $transactionId)
    {
        $globalPassbook = $this->get($globalPassbookId);

        $globalPassbook->transactions()->attach($transactionId);

        return true;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return GlobalPassbook::find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function gets()
    {
        return GlobalPassbook::all();
    }

    /**
     * @return mixed
     */
    public function lastBalance()
    {
        $global = GlobalPassbook::latest()->first();

        return (int) (!$global) ? 0 : $global->balance;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 20)
    {
        return GlobalPassbook::paginate($limit);
    }
}