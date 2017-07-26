<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\RemittanceInquiry;
use App\Contracts\RemittanceInquiryInterface;

class RemittanceInquiryRepository implements RemittanceInquiryInterface
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return RemittanceInquiry::find((int) $id);
    }

    /**
     * @param string $index
     * @param string $value
     * @return mixed
     */
    public function getBy(string $index, string $value)
    {
        return RemittanceInquiry::where(function ($query) use ($index, $value) {
            $query->where($index, $value);
        })->first();
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function save(array $data)
    {
        $inquiry = new RemittanceInquiry;

        foreach ($data as $item => $value) {
            $inquiry->$item = $value;
        }

        $inquiry->created_at = Carbon::now();
        $inquiry->updated_at = Carbon::now();

        return (!$inquiry->save()) ? false : $this->get((int) $inquiry->id);
    }
}