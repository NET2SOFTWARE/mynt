<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    protected $table = 'remittances';

    protected $fillable = [
        'transdatetime',
        'instid',
        'accountid',
        'name',
        'address',
        'countrycode',
        'birthdate',
        'birthplace',
        'phonenumber',
        'email',
        'occupation',
        'citizenship',
        'idnumber',
        'fundresource',
        'accountid1',

        'instid1',
        'name1',
        'relationship1',
        'regencycode1',
        'address1',
        'provcode1',
        'idnumber1',

        'accountid2',
        'instid2',
        'name2',
        'relationship2',
        'regencycode2',
        'address2',
        'provcode2',
        'idnumber2',

        'accountid3',
        'instid3',
        'name3',
        'relationship3',
        'regencycode3',
        'address3',
        'provcode3',
        'idnumber3',

        'accountid4',
        'instid4',
        'name4',
        'relationship4',
        'regencycode4',
        'address4',
        'provcode4',
        'idnumber4',

        'accountid5',
        'instid5',
        'name5',
        'relationship5',
        'regencycode5',
        'address5',
        'provcode5',
        'idnumber5',

        'sign',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_remittances', 'remittance_id', 'user_id')
            ->withTimestamps();
    }
}
