<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Passbook;
use App\Models\Transaction;
use App\Contracts\AccountInterface;
use App\Contracts\AbstractInterface;

class AccountRepository extends AbstractInterface implements AccountInterface
{

    /**
     * AccountRepository constructor.
     * @param Account $model
     */
    public function __construct(
        Account $model
    )
    {
        parent::__construct($model);
    }

    /**
     * @param $accountNumber
     * @return bool
     */
    public function isAccountRegistered($accountNumber)
    {
        $account = Account::where('number', '=', $accountNumber)
                            ->where('limit_balance', '>', 1000000)
                            ->first();

        return (count($account)) ? true : false;
    }

    /**
     * @param $accountNumber
     * @return null
     */
    public function getBalanceLimit($accountNumber)
    {
        $account = Account::where('number', '=', $accountNumber)->first();

        return (!$account) ? 0 : $account->limit_balance;
    }

    /**
     * @param $accountNumber
     * @return null
     */
    public function getTransactionLimit($accountNumber)
    {
        $account = Account::where('number', '=', $accountNumber)->first();

        return (!$account) ? null : $account->limit_balance_transaction;
    }

    /**
     * @param $accountNumber
     * @param $nominal
     * @return bool
     */
    public function isBalanceOverLimit($accountNumber, $nominal)
    {
        $temp_balance = (int) $this->getLastBalance($accountNumber) + $nominal;
        $balance_limit = (int) $this->getBalanceLimit($accountNumber);

        return ($temp_balance > $balance_limit) ? true : false;
    }

    /**
     * @param $accountNumber
     * @param $nominal
     * @return bool
     */
    public function isTransactionOverLimit($accountNumber, $nominal)
    {
        $limit = $this->getCalculateTransactionMonthly($accountNumber);

        $limit_monthly = $this->getTransactionLimit($accountNumber);

        return (($limit + $nominal) > $limit_monthly) ? true : false;
    }

    /**
     * @param $accountNumber
     * @param $nominal
     * @return bool
     */
    public function isBalanceEnough($accountNumber, $nominal)
    {
        if ($this->isBalanceNull($accountNumber))
            return false;

        return ($this->getLastBalance($accountNumber) >= $nominal) ? true : false;
    }

    /**
     * @param $accountNumber
     * @return bool
     */
    public function isBalanceNull($accountNumber)
    {
        $passbook = Passbook::whereHas('accounts', function ($query) use ($accountNumber) {
            $query->where('accounts.number', '=', $accountNumber);
        })->orderBy('created_at', 'DESC')->first();

        return (count($passbook) < 1) ? true : false;
    }

    /**
     * @param $accountNumber
     * @return int
     */
    public function getLastBalance($accountNumber)
    {
        if ($this->isBalanceNull($accountNumber))
            return 0;

        $passbook = Passbook::whereHas('accounts', function ($query) use ($accountNumber) {
            $query->where('accounts.number', '=', $accountNumber);
        })->orderBy('created_at', 'DESC')->first();

        return (int) (count($passbook) > 0) ? $passbook->balance : 0 ;
    }

    /**
     * @param string $accountNumber
     * @return mixed
     */
    public function getCalculateTransactionMonthly($accountNumber)
    {
        $start  = Carbon::now()->startOfMonth();
        $end    = Carbon::now();

        $transaction = Transaction::where('sender_account_number', '=', $accountNumber)
                                    ->orWhere('receiver_account_number', '=', $accountNumber)
                                    ->where('created_at', '>=', $start)
                                    ->where('created_at', '<=', $end)
                                    ->where('service_id', '<>', '5')
                                    ->where('status', '=', true)
                                    ->get();

        if (count($transaction) < 1) return 0;

        $total = collect($transaction)->sum('amount');

        return (int) $total;
    }


    /**
     * @param $accountNumber
     * @return mixed
     */
    public function isNullPin($accountNumber)
    {
        $account = Account::where('number', '=', $accountNumber)
                            ->whereNull('mynt_id')
                            ->first();

        return (count($account)) ? true : false;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $account = new Account;

        foreach ($data as $index => $value) { $account->$index = $value; }

        $account->created_at = Carbon::now();
        $account->updated_at = Carbon::now();

        $account->save();

        return (!$account) ? false : Account::find($account->id);
    }

    /**
     * @param $accountNumber
     * @return mixed
     */
    public function checkExistingAccount($accountNumber)
    {
        $account = Account::where('number', '=', $accountNumber)->first();

        return (count($account) > 0) ? $account : false;
    }

    /**
     * @param string $number
     * @return mixed
     */
    public function getAccountByNumber(string $number)
    {
        $account = Account::where('number', $number)->first();

        return (count($account) < 1) ? false : $account;
    }

    /**
     * @param string $myntId
     * @return mixed
     */
    public function getAccountByMyntId(string $myntId)
    {
        $account = Account::where('mynt_id', $myntId)->first();

        return (count($account) < 1) ? false : $account;
    }
}