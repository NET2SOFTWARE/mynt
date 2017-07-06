<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package App\Models
 */
class Token extends Model
{
    /**
     * @var string
     */
    protected $table = 'tokens';

    /**
     * @var array
     */
    protected $fillable = ['account_number', 'amount', 'reference_id', 'expired_at'];
}
