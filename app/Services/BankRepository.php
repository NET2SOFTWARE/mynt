<?php

namespace App\Services;

use App\Models\Bank;
use App\Contracts\AbstractInterface;
use App\Contracts\BankInterface;


/**
 * Class BankRepository
 * @package App\Services
 */
class BankRepository extends AbstractInterface implements BankInterface
{

    /**
     * BankRepository constructor.
     * @param Bank $model
     */
    public function __construct(Bank $model)
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
            'bank_code'     => $attributes['bank_code'],
            'bank_name'     => $attributes['bank_name'],
            'bank_account_number'   => $attributes['bank_account_number']
        ];
    }
}