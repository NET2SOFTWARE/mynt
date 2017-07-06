<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Charge
 * @package App\Models
 */
class Charge extends Model
{
    /**
     * @var string
     */
    protected $table = 'charges';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapping_charge()
    {
        return $this->hasMany(MappingCharge::class);
    }
}
