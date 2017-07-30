<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Passbook;
use App\Contracts\PassbookInterface;

/**
 * Class PassbookRepository
 * @package App\Services
 */
class PassbookRepository implements PassbookInterface
{

    /**
     * @param array $attributes
     * @return array
     */
    public function attribute(array $attributes)
    {
        return [
            'trx_id'    => $attributes['trx_id'],
            'credit'    => $attributes['credit'],
            'debit'     => $attributes['debit'],
            'balance'   => $attributes['balance'],
            'created_at'=>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param int $idPassbook
     * @return mixed
     */
    public function get(int $idPassbook)
    {
        $passbook = Passbook::find($idPassbook);

        return $passbook;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        $passbook = new Passbook;

        foreach ($data as $index => $value)
        {
            $passbook->$index = $value;
        }

        $passbook->save();

        return (!$passbook) ? false : $this->get($passbook->id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        return Passbook::create($this->attribute($data));
    }

    /**
     * @param int $idPassbook
     * @param int $idAccount
     * @return bool
     */
    public function attachAccounts(int $idPassbook, int $idAccount)
    {
        $passbook = Passbook::find($idPassbook);

        if (!$passbook) return false;

        $account = Account::find($idAccount);

        if (!$account) return false;

        $account->passbooks()->detact($idPassbook);

        return true;
    }

    /**
     * @param string $accountNumber
     * @param int $limit
     * @return bool
     */
    public function getPassbooksByAccountNumber(string $accountNumber, int $limit = 20)
    {
        $passbooks = Passbook::whereHas('accounts', function ($query) use ($accountNumber) {
            $query->where('accounts.number', '=', $accountNumber);
        })->paginate((int) $limit);

        return (count($passbooks) >= 1) ? $passbooks : false;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $passbook = Passbook::find($id);

        return $passbook->delete();
    }
}