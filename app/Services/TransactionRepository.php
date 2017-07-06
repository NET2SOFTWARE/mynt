<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Contracts\AbstractInterface;
use App\Contracts\TransactionInterface;

class TransactionRepository extends AbstractInterface implements TransactionInterface
{

    /**
     * TransactionRepository constructor.
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'trx_id'        => 0,
            'sender'        => $attributes['sender'],
            'receiver'      => $attributes['receiver'],
            'provider'      => $attributes['provider'],
            'amount'        => $attributes['amount'],
            'status'        => $attributes['status'],
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ];
    }

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function transactionSuccess(int $limit = 20, array $columns = ['*'])
    {
        return Transaction::where('status', true)->paginate($limit, $columns);
    }

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function transactionFailed(int $limit = 20, array $columns = ['*'])
    {
        return Transaction::where('status', false)->paginate($limit, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function inquiry(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $transaction = new Transaction;

        $transaction->trx_id    = 0;

        foreach ($data as $index => $value)
        {
            $transaction->$index = $value;
        }

        $transaction->created_at = Carbon::now();
        $transaction->updated_at = Carbon::now();

        $transaction->save();

        return (!$transaction) ? false : Transaction::find($transaction->id);
    }
}