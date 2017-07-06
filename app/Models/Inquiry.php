<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiries';

    protected $fillable = [
        'vaid',
        'reference_id',
        'account_number',
        'username',
        'signature',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
