<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemittanceInquiry extends Model
{
    protected $table = 'remittance_inquiries';

    protected $fillable = [
        'stan',
        'transdatetime',
        'instid',
        'proccode',
        'channeltype',
        'refnumber',
        'terminalid',
        'countrycode',
        'localdatetime',
        'accountid',
        'name',
        'currcode',
        'amount',
        'rate',
        'areacode',
        'instid2',
        'accountid2',
        'currcode2',
        'amount2',
        'custrefnumber',
        'regencycode',
        'purposecode',
        'purposedesc',
        'sign'
    ];
}
