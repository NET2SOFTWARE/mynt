<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    /**
     * @var string
     */
    protected $table = 'remittances';

    /**
     * @var array
     */
    protected $fillable = [
        'stan',
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

        'instid1',
        'accountid1',
        'name1',
        'relationship1',
        'regencycode1',
        'address1',
        'provcode1',
        'idnumber1',
        'sign',
        'bank_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_remittances', 'remittance_id', 'user_id')
            ->withTimestamps();
    }
}
