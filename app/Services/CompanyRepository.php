<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Company;
use App\Contracts\CompanyInterface;
use App\Contracts\AbstractInterface;



/**
 * Class CompanyRepository
 * @package App\Services
 */
class CompanyRepository extends AbstractInterface implements CompanyInterface
{
    /**
     * CompanyRepository constructor.
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'code'          => $attributes['code'],
            'name'          => $attributes['name'],
            'brand'         => $attributes['brand'],
            'email'         => $attributes['email'],
            'website'       => $attributes['website'],
            'industry_id'   => $attributes['industry_id'],
        ];
    }

    /**
     * @param string $partnership
     * @return mixed
     */
    public function sortCompanyByPartnership(string $partnership)
    {
        return $this->model
        ->whereHas('partnership', function ($query) use ($partnership) {
            $query->where('name', '=', $partnership);
        })->get();
    }

    /**
     * @param string $companyCode
     * @return mixed
     */
    public function getByCode(string $companyCode)
    {
        $company = $this->model->where('code', $companyCode)->first();

        return (!$company) ? false : $company;
    }

    /**
     * @param string $companyCode
     * @return mixed
     */
    public function getIdByCode(string $companyCode)
    {
        $company = $this->model->where('code', $companyCode)->first();

        return (!$company) ? false : $company->id;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $company = new Company;

        foreach ($data as $index => $value) { $company->$index = $value; }

        $company->created_at = Carbon::now();
        $company->updated_at = Carbon::now();

        $company->save();

        return (!$company) ? false : Company::find($company->id);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getCompanyByCode(string $code)
    {
        $company = Company::where('code', '=', $code)
                            ->first();

        return count($company) >= 1 ? $company : false;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getCompanyByUserId(int $userId)
    {
        $companies = Company::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', '=', $userId);
        })->get();

        return (count($companies) >= 1) ? $companies : false;
    }

    /**
     * @param string $accountNumber
     * @return mixed
     */
    public function getCompanyByAccountNumber(string $accountNumber)
    {
        $companies = Company::whereHas('accounts', function ($query) use ($accountNumber) {
            $query->where('accounts.number', '=', $accountNumber);
        })->get();
        
        return count($companies) >= 1 ? $companies : false;
    }
}