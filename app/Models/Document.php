<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function strtolower;
use function ucwords;

/**
 * Class Document
 * @package App\Models
 */
class Document extends Model
{
    /**
     * @var string
     */
    protected $table = 'documents';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'source'
    ];

    /**
     * @param $value
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getTypeAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * @param $value
     */
    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = strtolower($value);
    // }

    /**
     * @param $value
     * @return string
     */
    // public function getNameAttribute($value)
    // {
    //     return strtolower($value);
    // }

    /**
     * @param $value
     */
    // public function setSourceAttribute($value)
    // {
    //     $this->attributes['source'] = strtolower($value);
    // }

    /**
     * @param $value
     * @return string
     */
    // public function getSourceAttribute($value)
    // {
    //     return strtolower($value);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_documents', 'document_id', 'company_id')
            ->withTimestamps();
    }
}
