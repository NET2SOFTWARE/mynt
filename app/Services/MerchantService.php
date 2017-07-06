<?php

namespace App\Services;

use App\Models\Merchant;
use Carbon\Carbon;
use const false;
use Illuminate\Database\Connection;

/**
 * Class MerchantService
 * @package App\Services
 */
class MerchantService
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $db;

    /**
     * @var string
     */
    private $table;

    /**
     * MerchantService constructor.
     * @param \Illuminate\Database\Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;

        $this->table = 'merchants';
    }

    public function gets($paginate = null)
    {
        return (is_null($paginate))
            ? Merchant::all()
            : Merchant::paginate($paginate);
    }

    /**
     * @param string $index
     * @param $value
     * @return mixed
     */
    public function get($index = 'id', $value)
    {
        return $this->db
                    ->table($this->table)
                    ->where($index, '=', $value)
                    ->first();
    }

    /**
     * @param string $index
     * @param string $operator
     * @param $value
     * @return \Illuminate\Support\Collection
     */
    public function sort($index = 'name', $operator = 'like', $value)
    {
        $merchants = $this->db
            ->table($this->table)
            ->where($index, $operator, $value)
            ->get();

        return $merchants;
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    public function insert($data)
    {
        $id = $this->db
            ->table($this->table)
            ->insertGetId([
                'name'      => $data['name'],
                'brand'     => $data['brand'],
                'email'     => $data['email'],
                'website'   => $data['website'],
                'image'     => $data['image'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return ($id > 0)
            ? $this->get('id', $id)
            : (boolean) false;
    }
}