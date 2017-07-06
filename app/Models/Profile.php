<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App\Models
 */
class Profile extends Model
{
    /**
     * @var string
     */
    protected $table = 'profiles';

    /**
     * @var array
     */
    protected $fillable = [
        'gender',
        'born_place',
        'born_date',
        'identity_id',
        'identity_number',
        'identity_expired_date',
        'mother_name',
        'document',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    /**
     * @param $value
     */
    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @param $value
     */
    public function setBornPlaceAttribute($value)
    {
        $this->attributes['born_place'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getBornPlaceAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @param $value
     */
    public function setMotherNameAttribute($value)
    {
        $this->attributes['mother_name'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getMotherNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_profiles', 'profile_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identity()
    {
        return $this->belongsTo(Identity::class, 'identity_id');
    }
}
