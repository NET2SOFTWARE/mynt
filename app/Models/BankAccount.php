<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';

    protected $fillable = [
        'bank_code',
        'bank_name',
        'account_id',
        'name',
        'address',
        'provcode',
        'countrycode',
        'birthdate',
        'birthplace',
        'phonenumber',
        'email',
        'occupation',
        'citizenship',
        'idnumber',
        'fundresource',
    ];
}
