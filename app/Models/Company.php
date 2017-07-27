<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * @package App\Models
 */
class Company extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'brand',
        'phone',
        'email',
        'website',
        'photo',
        'industry_id'
    ];

    protected $casts = [
        'code'  => 'string'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        # return ucwords($value);
        $value = trim(ucwords($value));
        
        if (starts_with($value, 'Pt'))
        {
            $value = str_replace('Pt', 'PT', $value);

            if (! starts_with($value, 'PT.')) $value = str_replace('PT', 'PT.', $value);
        }

        return $value;
    }

    /**
     * @param $value
     */
    public function setBrandAttribute($value)
    {
        $this->attributes['brand'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getBrandAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @param $value
     */
    public function setWebsiteAttribute($value)
    {
        // $this->attributes['website'] = starts_with('http://', strtolower($value)) == true ? strtolower($value) : 'http://' . strtolower($value);
         $this->attributes['website'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getWebsiteAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_is('0*', $value) ? '62'. substr($value, 1) : $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_companies', 'company_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'company_locations', 'company_id', 'location_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'company_accounts', 'company_id', 'account_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function banks()
    {
        return $this->belongsToMany(Bank::class, 'company_banks', 'company_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'company_products', 'company_id', 'product_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partnerships()
    {
        return $this->belongsToMany(Partnership::class, 'company_partnerships', 'company_id', 'partnership_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_companies', 'company_id', 'member_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_companies', 'company_id', 'merchant_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product_purchase()
    {
        return $this->hasMany(ProductPurchase::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'company_documents', 'company_id', 'document_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pics()
    {
        return $this->belongsToMany(Pic::class, 'company_pics', 'company_id', 'pic_id')
            ->withTimestamps();
    }

    /**
     * @return array
     */
    public function getAllUserIds()
    {
        $ids = [];

        foreach ($this->users() as $user) {
            $ids = $user->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllContactIds()
    {
        $ids = [];

        foreach ($this->contacts() as $contact) {
            $ids = $contact->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllLocationIds()
    {
        $ids = [];

        foreach ($this->locations() as $location) {
            $ids = $location->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllBankIds()
    {
        $ids = [];

        foreach ($this->banks() as $bank) {
            $ids = $bank->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllProductIds()
    {
        $ids = [];

        foreach ($this->products() as $product) {
            $ids = $product->id;
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getAllPartnershipIds()
    {
        $ids = [];

        foreach ($this->partnerships() as $partnership) {
            $ids = $partnership->id;
        }

        return $ids;
    }
}
