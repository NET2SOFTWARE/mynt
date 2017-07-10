<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Merchant
 * @package App\Models
 */
class Merchant extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'merchants';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'brand',
        'email',
        'website',
        'phone',
        'image',
        'account_type'
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
        return ucwords($value);
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
        $this->attributes['website'] = str_is('http://*', $value) ? strtolower($value) : 'http://'. strtolower($value);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_merchants', 'merchant_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'merchant_accounts', 'merchant_id', 'account_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function banks()
    {
        return $this->belongsToMany(Bank::class, 'merchant_banks', 'merchant_id', 'bank_id')
            ->withPivot(['account_number'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'merchant_contacts', 'merchant_id', 'contact_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'merchant_locations', 'merchant_id', 'location_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partnerships()
    {
        return $this->belongsToMany(Partnership::class, 'merchant_partnerships', 'merchant_id', 'partnership_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'merchant_products', 'merchant_id', 'product_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function terminals()
    {
        return $this->belongsToMany(Terminal::class, 'merchant_terminals', 'merchant_id', 'terminal_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'merchant_companies', 'merchant_id', 'company_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product_sales()
    {
        return $this->hasMany(ProductSales::class);
    }

    /**
     * @return mixed
     */
    public function getAllAccountIds()
    {
        $ids = [];

        foreach ($this->accounts() as $account) {
            $ids = $account->id;
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
    public function getAllLocationtIds()
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
    public function getAllPartnershipIds()
    {
        $ids = [];

        foreach ($this->partnerships() as $partnership) {
            $ids = $partnership->id;
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
    public function getAllTerminalIds()
    {
        $ids = [];

        foreach ($this->terminals() as $terminal) {
            $ids = $terminal->id;
        }

        return $ids;
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
}
