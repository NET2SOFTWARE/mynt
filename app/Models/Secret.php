<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package App\Models
 */
class Secret extends Model
{
    /**
     * @var string
     */
    protected $table = 'oauth_clients';
}