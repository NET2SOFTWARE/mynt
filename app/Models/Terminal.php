<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Terminal
 * @package App\Models
 */
class Terminal extends Model
{
    /**
     * @var string
     */
    protected $table = 'terminals';

    /**
     * @var array
     */
    protected $fillable = ['code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_terminals', 'terminal_id', 'merchant_id')
            ->withTimestamps();
    }
}
