<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemittanceLog extends Model
{
	protected $table = 'remittance_logs';

    protected $fillable = [
    	'method',
    	'request',
    	'response',
    ];

    protected $appends = [
    	'stan',
    ];

    protected $casts = [
    	'request' => 'array',
    	'response' => 'array',
    ];

    public function GetStanAttribute()
    {
    	return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
