<?php

namespace App\Services;

use App\Contracts\RemittanceInterface;
use App\Models\Remittance;
use Carbon\Carbon;

class RemittanceRepository implements RemittanceInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $remittance = new Remittance;

        foreach ($data as $index => $value) {$remittance->$index = $value;}

        $remittance->created_at = Carbon::now();
        $remittance->updated_at = Carbon::now();

        return (!$remittance) ? false : Remittance::find($remittance->id);
    }

    /**
     * @param array $data
     */
    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param array $data
     */
    public function inquiry(array $data)
    {
        // TODO: Implement inquiry() method.
    }

    /**
     * @param array $data
     */
    public function inquiryStatus(array $data)
    {
        // TODO: Implement inquiryStatus() method.
    }

    /**
     * @param array $data
     */
    public function transfer(array $data)
    {
        // TODO: Implement transfer() method.
    }

    public function hash(string $data)
    {
        $param = md5($data);
        $der = '3020300C06082A86F70D020505000410';
        $concet = $der . $param;
        $length = 128 - ((int) strlen($concet)/2) - 3;

        $temp = '';
        for ($i=0; $i<strlen($concet);$i++) {
            $temp .= 'ff';
        }

        $hashed = '0001'.$temp.'00'.$concet;

        return $hashed;
    }
}