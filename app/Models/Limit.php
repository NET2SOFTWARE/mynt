<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Limit
 * @package App\Models
 */
class Limit extends Model
{
    /**
     * @var string
     */
    protected $table = 'limits';

    /**
     * @var array
     */
    protected $fillable  = ['name', 'balance_limit', 'transaction_limit', 'transaction_limit_monthly'];
}