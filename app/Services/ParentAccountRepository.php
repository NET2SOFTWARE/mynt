<?php

namespace App\Services;

use App\Models\ParentAccount;
use App\Contracts\ParentAccountInterface;
use Carbon\Carbon;

class ParentAccountRepository implements ParentAccountInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function getParent(int $id)
    {
        return ParentAccount::where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $parentAccount = new ParentAccount;

        foreach ($data as $index => $value){ $parentAccount->$index = $value; }

        $parentAccount->created_at = Carbon::now();
        $parentAccount->updated_at = Carbon::now();

        return (!$parentAccount) ? false : $this->getParent($parentAccount->id);
    }
}