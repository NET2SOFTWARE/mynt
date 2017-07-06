<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Merchant;
use App\Contracts\AbstractInterface;
use App\Contracts\MerchantInterface;
use App\Contracts\AccountInterface;


/**
 * Class MerchantRepository
 * @package App\Services
 */
class MerchantRepository implements MerchantInterface
{
    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function merchantGroup(int $limit = 20, array $columns = ['*'])
    {
        return $this->model->has('companies')->paginate($limit, $columns);
    }

    /**
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function merchantIndividual(int $limit = 20, array $columns = ['*'])
    {
        return $this->model->doesntHave('companies')->paginate($limit, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $merchant = new Merchant;

        foreach ($data as $index => $value) { $merchant->$index = $value; }

        $merchant->created_at = Carbon::now();
        $merchant->updated_at = Carbon::now();

        $merchant->save();

        return (!$merchant) ? false : Merchant::find($merchant->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return Merchant::find($id);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function gets(array $columns = ['*'])
    {
        return Merchant::all($columns);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $merchant = Merchant::find($id);

        foreach ($data as $index => $value) { $merchant->$index = $value; }

        $merchant->update();

        return (!$merchant) ? false : $this->get($merchant->id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $merchant = Merchant::find($id);

        return $merchant->delete();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function paginate(int $limit = 20)
    {
        $merchant = Merchant::paginate($limit);

        return $merchant;
    }
}