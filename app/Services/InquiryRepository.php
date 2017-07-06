<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Contracts\InquiryInterface;
use App\Contracts\AbstractInterface;
use Carbon\Carbon;


/**
 * Class InquiryRepository
 * @package App\Services
 */
class InquiryRepository extends AbstractInterface implements InquiryInterface
{

    /**
     * InquiryRepository constructor.
     * @param Inquiry $model
     */
    public function __construct(Inquiry $model)
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
            'reference_id'      => 0,
            'vaid'              => $attributes['vaid'],
            'account_number'    => $attributes['account_number'],
            'username'          => $attributes['username'],
            'signature'         => $attributes['signature'],
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ];
    }

    public function save(array $data)
    {
        $inquiry = new Inquiry;

        $inquiry->reference_id  = 0;
        foreach ($data as $index => $value)
        {
            $inquiry->$index = $value;
        }
        $inquiry->created_at = Carbon::now();
        $inquiry->updated_at = Carbon::now();

        $inquiry->save();

        return (!$inquiry) ? false : Inquiry::find($inquiry->id);
    }
}